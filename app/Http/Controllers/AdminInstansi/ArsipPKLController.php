<?php

namespace App\Http\Controllers\AdminInstansi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PenempatanPKL;
use App\Models\SuratKeterangan;
use App\Notifications\PesanNotifikasi;

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

        $filePath = $request->file('file_sk')->store('surat_keterangan', 'public');

        SuratKeterangan::updateOrCreate(
            ['id_penempatan' => $arsip->id_penempatan],
            [
                'nomor_surat' => 'SK-' . time(), 
                'tanggal_terbit' => now(),
                'file_surat' => $filePath,
            ]
        );
        $mahasiswa = $arsip->antrian->user;
        if ($mahasiswa) {
            $pesan = "Surat Keterangan Selesai PKL Anda telah terbit dan dapat diunduh.";
            $url = route('mahasiswa.download.sk');
            $mahasiswa->notify(new PesanNotifikasi($pesan, $url));
        }
        return redirect()->back()->with('success', 'Surat Keterangan berhasil diunggah untuk ' . $arsip->antrian->user->name);
    }
}
