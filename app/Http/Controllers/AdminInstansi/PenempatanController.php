<?php

namespace App\Http\Controllers\AdminInstansi;

use App\Http\Controllers\Controller;
use App\Models\AntrianPKL;
use App\Models\Bidang;
use App\Models\Pembimbing;
use App\Models\PenempatanPKL;
use Illuminate\Http\Request;

class PenempatanController extends Controller
{
    public function index()
    {
        // 1. Ambil semua mahasiswa yang dokumennya sudah lengkap ('Dokumen Lengkap')
        $mahasiswaSiap = AntrianPKL::where('status_antrian', 'Dokumen Lengkap')
            ->with('user')
            ->get();

        // 2. Ambil semua bidang untuk pilihan dropdown
        $daftarBidang = Bidang::orderBy('nama_bidang')->get();

        // 3. Kirim kedua data tersebut ke view
        return view('admin-instansi.penempatan-mahasiswa', compact('mahasiswaSiap', 'daftarBidang'));
    }

    /**
     * Menyimpan data penempatan mahasiswa ke sebuah bidang.
     */
    public function store(Request $request)
    {
        // 1. Validasi input dari form
        $request->validate([
            'antrian_id' => 'required|exists:antrian_pkl,id_antrian',
            'id_bidang' => 'required|exists:bidangs,id',
        ]);

        $antrian = AntrianPKL::find($request->antrian_id);
        $bidang = Bidang::find($request->id_bidang);
        // $pembimbing = Pembimbing::firstOrCreate(
        //     ['nama_pembimbing' => $request->nama_pembimbing]
        // );

        // 2. Cek apakah kuota bidang masih tersedia
        // if ($bidang->sisa_kuota < $antrian->jumlah_orang) {
        //     return redirect()->back()->with('error', 'Kuota untuk bidang ' . $bidang->nama_bidang . ' tidak mencukupi.');
        // }

        // 3. Buat record baru di tabel penempatan
        PenempatanPKL::updateOrCreate([
            'id_antrian' => $antrian->id_antrian,
            'id_pengguna' => $antrian->id_pengguna,
            'id_bidang' => $bidang->id,
            'id_pembimbing' => null,
            'status_pkl' => 'Menunggu Konfirmasi Admin Bidang',
        ]);

        // 4. Update status antrian utama menjadi selesai
        $antrian->update(['status_antrian' => 'Ditempatkan']);

        // 5. Kurangi sisa kuota di bidang terkait
        // $bidang->decrement('sisa_kuota', $antrian->jumlah_orang);

        return redirect()->route('admin-instansi.penempatan.index')->with('success', $antrian->user->name . ' berhasil dikirim di Bidang ' . $bidang->nama_bidang . 'untuk konfirmasi');
    }
}
