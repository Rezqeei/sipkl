<?php

namespace App\Http\Controllers\AdminBidang;

use App\Http\Controllers\Controller;
use App\Models\LaporanMingguan;
use App\Models\PenempatanPKL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
        {
            // 1. Dapatkan user admin yang sedang login
            $admin = Auth::user();

            // 2. Cari bidang yang dikelola oleh admin ini
            // PENTING: Pastikan di model User.php ada relasi 'bidang'
            $bidang = $admin->bidang;

            // Jika admin tidak terhubung ke bidang manapun, hentikan proses
            if (!$bidang) {
                // Tampilkan pesan error atau halaman khusus
                abort(403, 'Akun Anda tidak terhubung ke bidang manapun.');
            }

            // === MENGHITUNG DATA UNTUK KARTU STATISTIK ===
            
            // 3. Hitung jumlah mahasiswa yang sedang aktif di bidang ini
            $jumlahMahasiswaAktif = PenempatanPkl::where('id_bidang', $bidang->id)
                                                ->where('status_pkl', 'Sedang Berjalan')
                                                ->count();

            // 4. Hitung jumlah mahasiswa yang telah selesai di bidang ini
            $jumlahMahasiswaSelesai = PenempatanPKL::where('id_bidang', $bidang->id)
                                                  ->where('status_pkl', 'Selesai')
                                                  ->count();

            // === MENGAMBIL DATA UNTUK DAFTAR TUGAS TERBARU ===

            // 5. Ambil laporan mingguan baru yang perlu diverifikasi dari mahasiswa di bidang ini
            $laporanBaru = LaporanMingguan::where('status_verifikasi', 'Menunggu Verifikasi')
                                        ->whereHas('penempatan', function ($query) use ($bidang) {
                                            $query->where('id_bidang', $bidang->id);
                                        })
                                        ->with('penempatan.antrian') // Ambil data mahasiswa
                                        ->latest()
                                        ->take(5)
                                        ->get();
            
            // Kirim semua data yang sudah disiapkan ke view
            return view('admin-bidang.dashboard', compact(
                'bidang',
                'jumlahMahasiswaAktif',
                'jumlahMahasiswaSelesai',
                'laporanBaru'
            ));
        }
}
