<?php

namespace App\Http\Controllers\AdminInstansi;

use App\Http\Controllers\Controller;
use App\Models\AntrianPKL;
use App\Models\Bidang;
use App\Models\PenempatanPKL;
use Illuminate\Http\Request;

class PenempatanController extends Controller
{
    public function index()
        {
            // 1. Ambil semua mahasiswa yang dokumennya sudah lengkap
            $mahasiswaSiap = AntrianPkl::where('status_antrian', 'Dokumen Lengkap')->get();

            // 2. Ambil semua bidang yang aktif untuk pilihan dropdown
            $daftarBidang = Bidang::where('status_aktif', true)->get();

            // 3. Kirim kedua data tersebut ke view
            return view('admin-instansi.penempatan.index', compact('mahasiswaSiap', 'daftarBidang'));
        }

        /**
         * Menyimpan data penempatan mahasiswa ke sebuah bidang.
         */
        public function store(Request $request)
        {
            // 1. Validasi input dari form
            $request->validate([
                'antrian_id' => 'required|exists:antrian_pkl,id_antrian',
                'bidang_id' => 'required|exists:bidangs,id', // 'bidangs' adalah nama tabel bidang
            ]);

            $antrian = AntrianPKL::find($request->antrian_id);
            $bidang = Bidang::find($request->bidang_id);

            // 2. Cek apakah kuota bidang masih tersedia
            if ($bidang->sisa_kuota < $antrian->jumlah_orang) {
                return redirect()->back()->with('error', 'Kuota untuk bidang ' . $bidang->nama_bidang . ' tidak mencukupi.');
            }

            // 3. Buat record baru di tabel penempatan
            PenempatanPKL::create([
                'id_antrian' => $antrian->id_antrian,
                'id_pengguna' => $antrian->id_pengguna,
                'id_bidang' => $bidang->id,
                'status_pkl' => 'Sedang Berjalan', // Langsung set status menjadi aktif
            ]);

            // 4. Update status antrian utama menjadi selesai
            $antrian->update(['status_antrian' => 'Selesai']);

            // 5. Kurangi sisa kuota di bidang terkait
            $bidang->decrement('sisa_kuota', $antrian->jumlah_orang);

            return redirect()->back()->with('success', $antrian->nama_lengkap . ' berhasil ditempatkan di bidang ' . $bidang->nama_bidang);
        }
}
