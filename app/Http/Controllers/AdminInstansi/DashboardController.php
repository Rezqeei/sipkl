<?php

namespace App\Http\Controllers\AdminInstansi;

use App\Http\Controllers\Controller;
use App\Models\AntrianPKL;
use App\Models\Bidang;
use App\Models\DokumenPKL;
use App\Models\PenempatanPKL;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahPengajuanBaru = AntrianPKL::where('status_antrian', 'Menunggu Verifikasi')->count();

        $jumlahDokumenMenunggu = DokumenPKL::where('status_verifikasi', 'Menunggu Verifikasi')->count();

        $totalMahasiswaAktif = PenempatanPKL::where('status_pkl', 'Sedang Berjalan')->count();

        $totalBidangTersedia = Bidang::count();

        return view('admin-instansi.dashboard', compact(
            'jumlahPengajuanBaru',
            'jumlahDokumenMenunggu', 
            'totalMahasiswaAktif',
            'totalBidangTersedia'
        ));
    }
}
