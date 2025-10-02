<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\AntrianPKL;
use App\Models\DokumenPKL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanPKLController extends Controller
{
    public function create()
        {
            // Cek apakah mahasiswa sudah punya pengajuan aktif untuk mencegah duplikasi
            $pengajuanAktif = AntrianPkl::where('id_pengguna', Auth::id())
                                    ->whereIn('status_antrian', ['Menunggu Verifikasi', 'Diterima', 'Menunggu Verifikasi Dokumen', 'Dokumen Lengkap'])
                                    ->exists();

            if ($pengajuanAktif) {
                // Jika sudah ada, arahkan ke dashboard dengan pesan error
                return redirect()->route('mahasiswa.dashboard')->with('error', 'Anda sudah memiliki pengajuan PKL yang sedang diproses!');
            }

            // Jika belum ada, tampilkan form
            return view('mahasiswa.pengajuan-antrian');
        }
     public function store(Request $request)
    {
        // 1. Validasi semua input dari form
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:antrian_pkl,nim',
            'jurusan' => 'required|string|max:100',
            'nama_kampus' => 'required|string|max:100',
            'alamat' => 'required|string|max:1000',
            'tgl_mulai' => 'required|date',
            'tgl_berakhir' => 'required|date|after_or_equal:tgl_mulai',
            'jumlah_orang' => 'required|integer|min:1',
        ]);

        AntrianPkl::create([
            'id_pengguna' => Auth::id(), 
            'nama_lengkap' => $validated['nama_lengkap'],
            'nim' => $validated['nim'],
            'jurusan' => $validated['jurusan'],
            'nama_kampus' => $validated['nama_kampus'],
            'alamat' => $validated['alamat'],
            'tgl_mulai' => $validated['tgl_mulai'],
            'tgl_berakhir' => $validated['tgl_berakhir'],
            'jumlah_orang' => $validated['jumlah_orang'],
            'status_antrian' => 'Menunggu Verifikasi', // Status awal
        ]);

        return redirect()->route('mahasiswa.dashboard')->with('success', 'Pengajuan Antrian PKL berhasil dikirim dan sedang menunggu verifikasi.');
    }
}
