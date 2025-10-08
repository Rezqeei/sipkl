<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\LaporanAkhir;
use App\Models\LaporanMingguan;
use App\Models\PenempatanPKL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanPKLController extends Controller
{
    public function createMingguan()
    {
        $penempatan = PenempatanPkl::where('id_pengguna', Auth::id())
            ->where('status_pkl', 'Sedang Berjalan') // Pastikan PKL sedang berjalan
            ->with('laporanMingguan') // Ambil juga riwayat laporan mingguan
            ->first();

        // Jika tidak ada penempatan aktif, redirect dengan pesan error
        if (!$penempatan) {
            return redirect()->route('mahasiswa.dashboard')->with('error', 'Anda belum bisa mengunggah laporan mingguan saat ini.');
        }

        // Tampilkan view laporan-mingguan dengan data penempatan
        return view('mahasiswa.laporan-mingguan', compact('penempatan'));
    }

    /**
     * Menyimpan data laporan mingguan yang diunggah.
     */
    public function storeMingguan(Request $request)
    {
        $request->validate([
            'minggu_ke' => 'required|integer|min:1',
            'file_laporan' => 'required|file|mimes:pdf,docx|max:5120', // Batas file 5MB
        ]);

        $penempatan = PenempatanPkl::where('id_pengguna', Auth::id())->firstOrFail();

        // Simpan file ke folder 'laporan_mingguan' di dalam storage/app/public
        $path = $request->file('file_laporan')->store('laporan_mingguan', 'public');

        // Buat record baru di database
        LaporanMingguan::create([
            'id_penempatan' => $penempatan->id_penempatan,
            'minggu_ke' => $request->minggu_ke,
            'file_laporan' => $path,
            'status_verifikasi' => 'Menunggu Verifikasi', // Status awal
        ]);

        return redirect()->back()->with('success', 'Laporan mingguan berhasil diunggah.');
    }

    // --- METHOD UNTUK LAPORAN AKHIR (SUDAH ADA) ---
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

    /**
     * Menyimpan data laporan akhir yang diunggah.
     */
    public function storeAkhir(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi_singkat' => 'required|string',
            'file_laporan_akhir' => 'required|file|mimes:pdf,docx|max:10240', // Maks 5MB
        ]);

        $penempatan = PenempatanPkl::where('id_pengguna', Auth::id())->firstOrFail();
        $path = $request->file('file_laporan_akhir')->store('laporan_akhir', 'public');

        // 3. Buat entri baru di database dengan semua data yang diperlukan
        LaporanAkhir::create([
            'id_penempatan' => $request->penempatan_id,
            'judul' => $request->judul,
            'deskripsi_singkat' => $request->deskripsi_singkat,
            'file_laporan' => $path,
            'status_verifikasi' => 'Menunggu Verifikasi',
        ]);


        return redirect()->back()->with('success', 'Laporan akhir berhasil diunggah.');
    }
}
