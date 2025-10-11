<?php

namespace App\Http\Controllers\AdminBidang;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\PenempatanPKL;
use App\Models\LaporanMingguan;


class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $bidang = $user->bidangDikelola;

        if (!$bidang) {
            return view('admin-bidang.dashboard', ['bidang' => null]);
        }

        $mahasiswaAktifCount = PenempatanPKL::where('id_bidang', $bidang->id)
            ->where('status_pkl', 'Sedang Berjalan')
            ->count();

        $sisaKuota = $bidang->kuota - $mahasiswaAktifCount;

        $menungguKonfirmasiCount = PenempatanPKL::where('id_bidang', $bidang->id)
            ->where('status_pkl', 'Menunggu Konfirmasi Bidang')
            ->count();

        $daftarMenungguKonfirmasi = PenempatanPKL::with('mahasiswa', 'antrian')
            ->where('id_bidang', $bidang->id)
            ->where('status_pkl', 'Menunggu Konfirmasi Bidang')
            ->latest()
            ->take(5)
            ->get();

        $penempatanDiBidang = PenempatanPKL::with('antrian')->where('id_bidang', $bidang->id)->get();
        $idMahasiswaDiBidang = $penempatanDiBidang->map(function ($penempatan) {
            if ($penempatan->antrian) {
                return $penempatan->antrian->id_mahasiswa;
            }
            return null;
        })->filter();

        $laporanTerbaru = collect();
        $laporanPerluDicekCount = 0;

        if ($idMahasiswaDiBidang->isNotEmpty()) {
            $laporanTerbaru = LaporanMingguan::whereIn('id_mahasiswa', $idMahasiswaDiBidang)
                ->with('mahasiswa')
                ->latest()
                ->take(5)
                ->get();

            $laporanPerluDicekCount = LaporanMingguan::whereIn('id_mahasiswa', $idMahasiswaDiBidang)
                ->where('status_verifikasi', 'Menunggu Verifikasi')->count();
        }

        return view('admin-bidang.dashboard', compact(
            'bidang',
            'mahasiswaAktifCount',
            'sisaKuota',
            'menungguKonfirmasiCount',
            'laporanPerluDicekCount',
            'daftarMenungguKonfirmasi',
            'laporanTerbaru'
        ));
    }
}
