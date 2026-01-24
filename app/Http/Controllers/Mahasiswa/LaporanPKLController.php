<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\LaporanAkhir;
use App\Models\LaporanMingguan;
use App\Models\PenempatanPKL;
use App\Notifications\PesanNotifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanPKLController extends Controller
{
    public function createMingguan()
    {
        $penempatan = PenempatanPkl::where('id_pengguna', Auth::id())
            ->where('status_pkl', 'Sedang Berjalan')
            ->with('laporanMingguan')
            ->first();

        if (!$penempatan) {
            return redirect()->route('mahasiswa.dashboard')->with('error', 'Anda belum bisa mengunggah laporan mingguan saat ini.');
        }

        return view('mahasiswa.laporan-mingguan', compact('penempatan'));
    }
    public function storeMingguan(Request $request)
    {
        $request->validate([
            'minggu_ke' => 'required|integer|min:1',
            'file_laporan' => 'required|file|mimes:pdf,docx|max:5120',
        ]);

        $penempatan = PenempatanPkl::where('id_pengguna', Auth::id())->firstOrFail();

        $path = $request->file('file_laporan')->store('laporan_mingguan', 'public');

        LaporanMingguan::create([
            'id_penempatan' => $penempatan->id_penempatan,
            'minggu_ke' => $request->minggu_ke,
            'file_laporan' => $path,
            'status_verifikasi' => 'Menunggu Verifikasi',
        ]);

        $adminBidang = $penempatan->bidang->adminBidang;
        if ($adminBidang) {
            $mahasiswa = Auth::user();
            $pesan = "Laporan mingguan ke-{$request->minggu_ke} dari {$mahasiswa->name} telah diunggah.";
            $url = route('admin-bidang.monitoring.laporan.mingguan');
            $adminBidang->notify(new PesanNotifikasi($pesan, $url));
        }

        return redirect()->back()->with('success', 'Laporan mingguan berhasil diunggah.');
    }
    public function createAkhir()
    {
        $penempatan = PenempatanPkl::where('id_pengguna', Auth::id())
            ->where('status_pkl', 'Sedang Berjalan', 'Selesai')
            ->with('laporanAkhir')
            ->first();
        if (!$penempatan) {
            return redirect()->route('mahasiswa.dashboard')->with('error', 'Anda tidak dapat mengunggah laporan saat ini.');
        }
        return view('mahasiswa.laporan-akhir', compact('penempatan'));
    }
    public function storeAkhir(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi_singkat' => 'required|string',
            'file_laporan_akhir' => 'required|file|mimes:pdf,docx|max:10240',
        ]);

        $penempatan = PenempatanPkl::where('id_pengguna', Auth::id())->firstOrFail();
        $path = $request->file('file_laporan_akhir')->store('laporan_akhir', 'public');

        LaporanAkhir::create([
            'id_penempatan' => $request->penempatan_id,
            'judul' => $request->judul,
            'deskripsi_singkat' => $request->deskripsi_singkat,
            'file_laporan' => $path,
            'status_verifikasi' => 'Menunggu Verifikasi',
        ]);

        $adminBidang = $penempatan->bidang->adminBidang;
        if ($adminBidang) {
            $mahasiswa = Auth::user();
            $pesan = "Laporan akhir dari {$mahasiswa->name} telah diunggah dan perlu verifikasi.";
            $url = route('admin-bidang.monitoring.laporan.akhir');
            $adminBidang->notify(new PesanNotifikasi($pesan, $url));
        }

        return redirect()->back()->with('success', 'Laporan akhir berhasil diunggah.');
    }
}
