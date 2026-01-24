<?php

namespace App\Http\Controllers\AdminInstansi;

use App\Http\Controllers\Controller;
use App\Models\AntrianPKL;
use App\Notifications\PesanNotifikasi;
use Illuminate\Http\Request;

class VerifikasiPengajuanController extends Controller
{
    public function index()
    {
        $daftarPengajuan = AntrianPkl::where('status_antrian', 'Menunggu Verifikasi')
            ->orderBy('created_at', 'asc') 
            ->get();

        return view('admin-instansi.verifikasi-antrian', compact('daftarPengajuan'));
    }

    public function update(Request $request, AntrianPkl $antrian)
    {
        $request->validate([
            'action' => 'required|in:terima,tolak',
            'alasan_penolakan' => 'nullable|string|max:500|required_if:action,tolak',
        ]);

        $mahasiswa = $antrian->user;

        if ($request->action === 'terima') {
            $antrian->update([
                'status_antrian' => 'Diterima',
                'alasan_penolakan' => null, 
            ]);
            $message = 'Pengajuan untuk ' . $antrian->user->name . ' telah DITERIMA.';

            $pesan = "Selamat! Pengajuan antrian PKL Anda telah diterima. Silakan segera unggah dokumen yang diperlukan.";
            $url = route('mahasiswa.unggah.dokumen');
            $mahasiswa->notify(new PesanNotifikasi($pesan, $url));
        } else {
            $antrian->update([
                'status_antrian' => 'Ditolak',
                'alasan_penolakan' => $request->alasan_penolakan,
            ]);
            $message = 'Pengajuan untuk ' . $antrian->user->name . ' telah DITOLAK.';
            $pesan = "Maaf, pengajuan antrian PKL Anda ditolak. Alasan: {$request->alasan_penolakan}";
            $url = route('mahasiswa.dashboard');
            $mahasiswa->notify(new PesanNotifikasi($pesan, $url));
        }
        return redirect()->route('admin-instansi.verifikasi-pengajuan.index')->with('success', $message);
    }
}
