<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\AntrianPKL;
use App\Models\Bidang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardMahasiswaController extends Controller
{
    public function index()
    {
        // Ambil data antrian terakhir mahasiswa yang login.
        $antrian = AntrianPKL::where('id_pengguna', Auth::id())->with(['dokumen', 'penempatan.bidang', 'penempatan.laporanMingguan', 'penempatan.laporanAkhir'])->latest()->first();

        // Kirim data 'antrian' ke view.
        return view('mahasiswa.dashboard', compact('antrian'));
    }

    /**
     * Menampilkan halaman identitas dinas.
     */
    public function identitasDinas()
    {
        // Data ini bisa dipindah ke config atau database nanti.
        $dinas = [
            'nama' => 'Dinas Komunikasi Informatika',
            'alamat' => 'Jl. Pembangunan, No. 123',
            'telepon' => '(021) 12345678',
            'email' => 'diskominfo@example.go.id',
        ];
        $bidangs = Bidang::all();

        // Kirim data 'dinas' ke view.
        return view('mahasiswa.identitas-dinas', compact('bidangs'));
    }
}
