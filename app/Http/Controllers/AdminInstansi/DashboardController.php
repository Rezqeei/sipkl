<?php

namespace App\Http\Controllers\AdminInstansi;

use App\Http\Controllers\Controller;
use App\Models\AntrianPKL;
use App\Models\PenempatanPKL;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // === MENGHITUNG DATA UNTUK KARTU STATISTIK ===

        // 1. Menghitung jumlah pengajuan antrian baru yang perlu diverifikasi.
        $jumlahPengajuanBaru = AntrianPkl::where('status_antrian', 'Menunggu Verifikasi')->count();

        // 2. Menghitung jumlah dokumen mahasiswa yang perlu diverifikasi.
        $jumlahDokumenMenunggu = AntrianPkl::where('status_antrian', 'Menunggu Verifikasi Dokumen')->count();

        // 3. Menghitung jumlah mahasiswa yang sedang aktif PKL.
        $jumlahMahasiswaAktif = PenempatanPkl::where('status_pkl', 'Sedang Berjalan')->count();

        // 4. Menghitung jumlah mahasiswa yang telah selesai PKL.
        $jumlahMahasiswaSelesai = PenempatanPKL::where('status_pkl', 'Selesai')->count();


        // === MENGAMBIL DATA UNTUK DAFTAR TUGAS TERBARU ===

        // Mengambil 5 pengajuan terbaru yang membutuhkan tindakan (antrian baru atau dokumen baru)
        $tugasTerbaru = AntrianPKL::whereIn('status_antrian', [
            'Menunggu Verifikasi', 
            'Menunggu Verifikasi Dokumen'
        ])
        ->latest() // Urutkan dari yang paling baru
        ->take(5)  // Ambil 5 data teratas
        ->get();

        return view('admin-instansi.dashboard');
    }
}
