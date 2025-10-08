<?php

namespace App\Http\Controllers\AdminBidang;

use App\Http\Controllers\Controller;
use App\Models\LaporanAkhir;
use App\Models\LaporanMingguan;
use App\Models\PenempatanPKL;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MonitoringLaporanController extends Controller
{
    public function showMingguan()
    {
        // Menggunakan relasi yang sudah diperbaiki: `bidangDikelola`
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

    /**
     * Memverifikasi status laporan mingguan.
     */
    public function verifyMingguan(Request $request, $id_laporan)
    {
        $request->validate(['status_verifikasi' => 'required|in:Disetujui,Ditolak']);
        $laporan = LaporanMingguan::findOrFail($id_laporan);

        // --- PERBAIKAN KONDISI OTORISASI ---
        // Membandingkan ID bidang dari laporan dengan ID bidang yang dikelola admin.
        if ($laporan->penempatan->id_bidang !== (Auth::user()->bidangDikelola->id ?? null)) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        $laporan->update(['status_verifikasi' => $request->status_verifikasi]);
        return redirect()->back()->with('success', 'Status laporan berhasil diperbarui.');
    }

    /**
     * Menampilkan daftar laporan akhir dari mahasiswa di bidang terkait.
     */
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

    /**
     * Memverifikasi status laporan akhir.
     */
    public function verifyAkhir(Request $request, $id)
    {
        $request->validate([
            'status_verifikasi' => 'required|in:Disetujui,Ditolak',
            // 'feedback' hanya wajib diisi jika statusnya 'Ditolak'
            'feedback' => 'nullable|string|required_if:status_verifikasi,Ditolak',
        ], [
            // Pesan error kustom agar lebih jelas
            'feedback.required_if' => 'Alasan penolakan wajib diisi jika laporan ditolak.'
        ]);

        $laporan = LaporanAkhir::findOrFail($id);

        // 2. Otorisasi untuk memastikan admin hanya bisa memverifikasi laporan di bidangnya
        if ($laporan->penempatan->id_bidang !== (Auth::user()->bidangDikelola->id ?? null)) {
            return redirect()->back()->with('error', 'Anda tidak berwenang melakukan aksi ini.');
        }

        // 3. Update data laporan berdasarkan input dari form
        $laporan->status_verifikasi = $request->status_verifikasi;
        // Jika disetujui, feedback dikosongkan. Jika ditolak, feedback diisi.
        $laporan->feedback = $request->status_verifikasi === 'Ditolak' ? $request->feedback : null;
        $laporan->save();

        // 4. Jika laporan disetujui, otomatis ubah status PKL mahasiswa menjadi 'Selesai'
        if ($request->status_verifikasi === 'Disetujui') {
            $laporan->penempatan->update(['status_pkl' => 'Selesai']);
        }

        return redirect()->back()->with('success', 'Status laporan akhir berhasil diperbarui.');
    }

    /**
     * Mengunduh file laporan mingguan.
     */
    public function downloadMingguan($id_laporan)
    {
        $laporan = LaporanMingguan::findOrFail($id_laporan);

        // --- PERBAIKAN KONDISI OTORISASI ---
        // Membandingkan ID bidang dari laporan dengan ID bidang yang dikelola admin.
        if ($laporan->penempatan->id_bidang !== (Auth::user()->bidangDikelola->id ?? null)) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        $pathToFile = storage_path('app/public/' . $laporan->file_laporan);

        if (file_exists($pathToFile)) {
            return response()->download($pathToFile);
        }

        return redirect()->back()->with('error', 'File tidak ditemukan.');
    }

    /**
     * Mengunduh file laporan akhir.
     */
    public function downloadAkhir($id)
    {
        $laporan = LaporanAkhir::findOrFail($id);

        // Otorisasi: Pastikan admin hanya bisa unduh laporan di bidangnya
        if ($laporan->penempatan->id_bidang !== (Auth::user()->bidangDikelola->id ?? null)) {
            abort(403, 'Akses ditolak.');
        }

        $pathToFile = $laporan->file_laporan;

        // Cek apakah file ada di disk 'public'
        if (Storage::disk('public')->exists($pathToFile)) {
            return response()->download(Storage::disk('public')->path($pathToFile));
        }

        return redirect()->back()->with('error', 'File laporan akhir tidak ditemukan.');
    }
}
