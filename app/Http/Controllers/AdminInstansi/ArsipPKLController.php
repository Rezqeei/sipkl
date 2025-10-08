<?php

namespace App\Http\Controllers\AdminInstansi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PenempatanPKL;
use App\Models\SuratKeterangan;

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

    public function storeSk(Request $request, PenempatanPKL $arsip)
    {
        $request->validate([
            'file_sk' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Simpan file SK
        $filePath = $request->file('file_sk')->store('surat_keterangan', 'public');

        // Buat atau update record di tabel surat_keterangan
        SuratKeterangan::updateOrCreate(
            ['id_penempatan' => $arsip->id_penempatan],
            [
                'nomor_surat' => 'SK-' . time(), // Anda bisa sesuaikan format nomor surat
                'tanggal_terbit' => now(),
                'file_surat' => $filePath,
            ]
        );

        return redirect()->back()->with('success', 'Surat Keterangan berhasil diunggah untuk ' . $arsip->antrian->user->name);
    }
}
