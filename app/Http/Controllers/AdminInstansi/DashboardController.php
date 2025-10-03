<?php

namespace App\Http\Controllers\AdminInstansi;

use App\Http\Controllers\Controller;
use App\Models\AntrianPKL;
use App\Models\Bidang;
use App\Models\DokumenPKL;
use App\Models\PenempatanPKL;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung jumlah antrian PKL yang statusnya 'Menunggu Verifikasi'
        $jumlahPengajuanBaru = AntrianPKL::where('status_antrian', 'Menunggu Verifikasi')->count();

        // 2. Hitung jumlah dokumen yang status verifikasinya 'Menunggu Verifikasi'
        $jumlahDokumenMenunggu = DokumenPKL::where('status_verifikasi', 'Menunggu Verifikasi')->count();

        // Hitung jumlah mahasiswa yang status PKL-nya 'Aktif'
        $totalMahasiswaAktif = PenempatanPKL::where('status_pkl', 'Aktif')->count();

        // Hitung total bidang yang terdaftar
        $totalBidangTersedia = Bidang::count();

        // Kirim semua variabel data ke view
        return view('admin-instansi.dashboard', compact(
            'jumlahPengajuanBaru',
            'jumlahDokumenMenunggu', // 3. Kirim variabel baru ini ke view
            'totalMahasiswaAktif',
            'totalBidangTersedia'
        ));
    }
}
