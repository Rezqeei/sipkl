<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\AntrianPKL;
use App\Models\User;
use App\Notifications\PesanNotifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;


class PengajuanPKLController extends Controller
{
    public function create()
        {
            $pengajuanAktif = AntrianPkl::where('id_pengguna', Auth::id())
                                    ->whereIn('status_antrian', ['Menunggu Verifikasi', 'Diterima', 'Menunggu Verifikasi Dokumen', 'Dokumen Lengkap'])
                                    ->exists();

            if ($pengajuanAktif) {
                return redirect()->route('mahasiswa.dashboard')->with('error', 'Anda sudah memiliki pengajuan PKL yang sedang diproses!');
            }

            return view('mahasiswa.pengajuan-antrian');
        }
     public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nim' => [
                'required',
                'string',
                'max:20',
                Rule::unique('antrian_pkl', 'nim')->where(function ($query) {
                    return $query->where('status_antrian', '!=', 'Ditolak');
                }),
            ],
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
            'status_antrian' => 'Menunggu Verifikasi', 
        ]);

        $adminsInstansi = User::where('role', 'admin_instansi')->get();
        $pesan = "Pengajuan antrian PKL baru dari {$validated['nama_lengkap']} perlu diverifikasi.";
        $url = route('admin-instansi.verifikasi-pengajuan.index');

        Notification::send($adminsInstansi, new PesanNotifikasi($pesan, $url));

        return redirect()->route('mahasiswa.dashboard')->with('success', 'Pengajuan Antrian PKL berhasil dikirim dan sedang menunggu verifikasi.');
    }
}
