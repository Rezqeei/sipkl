<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\AntrianPKL;
use App\Models\Bidang;
use Illuminate\Support\Facades\Auth;

class DashboardMahasiswaController extends Controller
{
    public function index()
    {
        $antrian = AntrianPKL::where('id_pengguna', Auth::id())
            ->with([
                'dokumen',
                'penempatan.bidang',
                'penempatan.pembimbing',
                'penempatan.laporanMingguan', 
                'penempatan.laporanAkhir' => function ($query) {
                    $query->latest('updated_at');
                }
            ])->latest()->first();

        return view('mahasiswa.dashboard', compact('antrian'));
    }

    
    public function identitasDinas()
    {
        $dinas = [
            'nama' => 'Dinas Komunikasi Informatika',
            'alamat' => 'Jl. Pembangunan, No. 123',
            'telepon' => '(021) 12345678',
            'email' => 'diskominfo@example.go.id',
        ];
        $bidangs = Bidang::all();

        return view('mahasiswa.identitas-dinas', compact('bidangs'));
    }
}
