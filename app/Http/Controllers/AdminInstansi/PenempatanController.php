<?php

namespace App\Http\Controllers\AdminInstansi;

use App\Http\Controllers\Controller;
use App\Models\AntrianPKL;
use App\Models\Bidang;
use App\Models\PenempatanPKL;
use App\Models\User;
use App\Notifications\PesanNotifikasi;
use Illuminate\Http\Request;

class PenempatanController extends Controller
{
    public function index()
    {
        $mahasiswaSiap = AntrianPKL::where('status_antrian', 'Dokumen Lengkap')
            ->with('user')
            ->get();

        $daftarBidang = Bidang::orderBy('nama_bidang')->get();

        return view('admin-instansi.penempatan-mahasiswa', compact('mahasiswaSiap', 'daftarBidang'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'antrian_id' => 'required|exists:antrian_pkl,id_antrian',
            'id_bidang' => 'required|exists:bidangs,id',
        ]);

        $antrian = AntrianPKL::find($request->antrian_id);
        $bidang = Bidang::find($request->id_bidang);

        PenempatanPKL::updateOrCreate([
            'id_antrian' => $antrian->id_antrian,
            'id_pengguna' => $antrian->id_pengguna,
            'id_bidang' => $bidang->id,
            'id_pembimbing' => null,
            'status_pkl' => 'Menunggu Konfirmasi Admin Bidang',
        ]);

        $antrian->update(['status_antrian' => 'Ditempatkan']);
        $adminBidang = User::find($bidang->id_admin_bidang);
        if ($adminBidang) {
            $pesan = "Mahasiswa baru (" . $antrian->user->name . ") telah ditempatkan di bidang Anda dan menunggu konfirmasi.";
            $url = route('admin-bidang.konfirmasi-mahasiswa');
            $adminBidang->notify(new PesanNotifikasi($pesan, $url));
        }

        return redirect()->route('admin-instansi.penempatan.index')->with('success', $antrian->user->name . ' berhasil dikirim di Bidang ' . $bidang->nama_bidang . 'untuk konfirmasi');
    }
}
