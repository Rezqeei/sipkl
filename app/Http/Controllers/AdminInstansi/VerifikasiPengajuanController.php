<?php

namespace App\Http\Controllers\AdminInstansi;

use App\Http\Controllers\Controller;
use App\Models\AntrianPKL;
use App\Models\DokumenPKL;
use Illuminate\Http\Request;

class VerifikasiPengajuanController extends Controller
{
    public function index()
    {
        // Ambil semua data antrian yang statusnya 'Menunggu Verifikasi'
        $daftarPengajuan = AntrianPkl::where('status_antrian', 'Menunggu Verifikasi')
            ->orderBy('created_at', 'asc') // Tampilkan yang paling lama dulu
            ->get();

        // Kirim data tersebut ke view
        return view('admin-instansi.verifikasi-antrian', compact('daftarPengajuan'));
    }

    /**
     * Memproses keputusan verifikasi (Terima atau Tolak).
     */
    public function update(Request $request, AntrianPkl $antrian) 
    {
        // 1. Validasi input dari form admin
        $request->validate([
            'action' => 'required|in:terima,tolak',
            // Alasan wajib diisi jika aksinya adalah 'tolak'
            'alasan_penolakan' => 'nullable|string|max:500|required_if:action,tolak',
        ]);

        // 2. Lakukan aksi berdasarkan input 'action'
        if ($request->action === 'terima') {
            $antrian->update([
                'status_antrian' => 'Diterima',
                'alasan_penolakan' => null, // Pastikan alasan kosong jika diterima
            ]);
            $message = 'Pengajuan untuk ' . $antrian->user->name . ' telah DITERIMA.';
        } else { // Jika aksinya 'tolak'
            $antrian->update([
                'status_antrian' => 'Ditolak',
                'alasan_penolakan' => $request->alasan_penolakan,
            ]);
            $message = 'Pengajuan untuk ' . $antrian->user->name . ' telah DITOLAK.';
        }
        return redirect()->route('admin-instansi.verifikasi-pengajuan.index')->with('success', $message);
    }
}
