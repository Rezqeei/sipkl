<?php

namespace App\Http\Controllers\AdminBidang;

use App\Http\Controllers\Controller;
use App\Models\LaporanAkhir;
use App\Models\LaporanMingguan;
use App\Notifications\PesanNotifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MonitoringLaporanController extends Controller
{
    public function showMingguan()
    {
        $id_bidang = Auth::user()->bidangDikelola->id ?? null;

        if (!$id_bidang) {
            return view('admin-bidang.laporan-mingguan', ['laporans' => collect()]);
        }

        $laporans = LaporanMingguan::whereHas('penempatan', function ($query) use ($id_bidang) {
            $query->where('id_bidang', $id_bidang);
        })->with([
            'penempatan.mahasiswa',
            'penempatan.antrian'
        ])
            ->where('status_verifikasi', 'Menunggu Verifikasi')
            ->orderBy('created_at', 'desc')->get();

        return view('admin-bidang.laporan-mingguan', compact('laporans'));
    }
    public function verifyMingguan(Request $request, $id_laporan)
    {
        $request->validate(['status_verifikasi' => 'required|in:Disetujui,Ditolak']);
        $laporan = LaporanMingguan::findOrFail($id_laporan);

        if ($laporan->penempatan->id_bidang !== (Auth::user()->bidangDikelola->id ?? null)) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }
        $laporan->update(['status_verifikasi' => $request->status_verifikasi]);
        $mahasiswa = $laporan->penempatan->mahasiswa;
        if ($mahasiswa) {
            $status = $request->status_verifikasi;
            $pesan = "Laporan mingguan Anda (Minggu ke-{$laporan->minggu_ke}) telah diverifikasi dengan status: {$status}.";
            $url = route('mahasiswa.laporan.mingguan');
            $mahasiswa->notify(new PesanNotifikasi($pesan, $url));
        }
        return redirect()->back()->with('success', 'Status laporan berhasil diperbarui.');
    }
    public function showAkhir()
    {
        $id_bidang = Auth::user()->bidangDikelola->id ?? null;

        if (!$id_bidang) {
            $laporanAkhir = collect();
        } else {
            $laporanAkhir = LaporanAkhir::with(['penempatan.antrian.user'])
                ->whereHas('penempatan', function ($query) use ($id_bidang) {
                    $query->where('id_bidang', $id_bidang);
                })
                ->where('status_verifikasi', 'Menunggu Verifikasi')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('admin-bidang.laporan-akhir', compact('laporanAkhir'));
    }
    public function verifyAkhir(Request $request, $id)
    {
        $request->validate([
            'status_verifikasi' => 'required|in:Disetujui,Ditolak',
            'feedback' => 'nullable|string|required_if:status_verifikasi,Ditolak',
        ], [
            'feedback.required_if' => 'Alasan penolakan wajib diisi jika laporan ditolak.'
        ]);

        $laporan = LaporanAkhir::findOrFail($id);

        if ($laporan->penempatan->id_bidang !== (Auth::user()->bidangDikelola->id ?? null)) {
            return redirect()->back()->with('error', 'Anda tidak berwenang melakukan aksi ini.');
        }

        $laporan->status_verifikasi = $request->status_verifikasi;
        $laporan->feedback = $request->status_verifikasi === 'Ditolak' ? $request->feedback : null;
        $laporan->save();

        if ($request->status_verifikasi === 'Disetujui') {
            $laporan->penempatan->update(['status_pkl' => 'Selesai']);
        }
        $mahasiswa = $laporan->penempatan->antrian->user;
        $status = strtolower($request->action);
        $pesan = "Laporan akhir Anda telah diverifikasi dengan status: {$status}.";
        if ($request->action == 'Revisi') {
            $pesan .= " Catatan: " . $request->feedback;
        } elseif ($request->action == 'Diterima') {
            $pesan .= " Selamat, Anda telah menyelesaikan PKL! Silakan download Surat Keterangan Selesai.";
        }
        $url = route('mahasiswa.laporan.akhir');
        $mahasiswa->notify(new PesanNotifikasi($pesan, $url));

        return redirect()->back()->with('success', 'Status laporan akhir berhasil diperbarui.');
    }
    public function downloadMingguan($id_laporan)
    {
        $laporan = LaporanMingguan::findOrFail($id_laporan);

        if ($laporan->penempatan->id_bidang !== (Auth::user()->bidangDikelola->id ?? null)) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        $pathToFile = storage_path('app/public/' . $laporan->file_laporan);

        if (file_exists($pathToFile)) {
            return response()->download($pathToFile);
        }

        return redirect()->back()->with('error', 'File tidak ditemukan.');
    }
    public function downloadAkhir($id)
    {
        $laporan = LaporanAkhir::findOrFail($id);

        if ($laporan->penempatan->id_bidang !== (Auth::user()->bidangDikelola->id ?? null)) {
            abort(403, 'Akses ditolak.');
        }

        $pathToFile = $laporan->file_laporan;

        if (Storage::disk('public')->exists($pathToFile)) {
            return response()->download(Storage::disk('public')->path($pathToFile));
        }

        return redirect()->back()->with('error', 'File laporan akhir tidak ditemukan.');
    }
}
