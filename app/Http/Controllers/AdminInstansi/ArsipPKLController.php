<?php

namespace App\Http\Controllers\AdminInstansi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PenempatanPKL;

class ArsipPKLController extends Controller
{
    public function index()
    {
        $arsipMahasiswa = PenempatanPKL::with('antrian.user', 'bidang')
                                         ->where('status_pkl', 'Selesai')
                                         ->orderBy('created_at', 'desc')
                                         ->get();
                                         
        return view('admin-instansi.arsip-pkl', compact('arsipMahasiswa'));
    }
}
