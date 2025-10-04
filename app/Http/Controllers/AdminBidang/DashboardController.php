<?php

namespace App\Http\Controllers\AdminBidang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PenempatanPKL;
use App\Models\AntrianPKL;
use App\Models\Bidang;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $admin = Auth::user();
        $bidang = $admin->bidang;

        if ($bidang) {
            $jumlahMahasiswa = PenempatanPKL::where('id_bidang', $bidang->id)->count();
            $jumlahAntrian = AntrianPKL::where('id_bidang', $bidang->id)->count();
            $kuotaTersedia = $bidang->kuota - PenempatanPKL::where('id_bidang', $bidang->id)->count();
        } else {
            $jumlahMahasiswa = 0;
            $jumlahAntrian = 0;
            $kuotaTersedia = 0;
        }
        return view('admin-bidang.dashboard', [
            'totalMahasiswa' => $jumlahMahasiswa,
            'totalAntrian' => $jumlahAntrian,
            'kuotaTersedia' => $kuotaTersedia,
            'bidang' => $bidang,
        ]);
    }
}
