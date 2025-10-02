<?php

namespace App\Http\Controllers\AdminInstansi;

use App\Http\Controllers\Controller;
use App\Models\AntrianPKL;
use App\Models\DokumenPKL;
use Illuminate\Http\Request;

class VerifikasiDokumenController extends Controller
{
    public function index()
        {
            // Ambil semua antrian yang statusnya 'Menunggu Verifikasi Dokumen'
            // Kita juga ambil data relasi 'dokumen' agar bisa diakses di view
            $daftarDokumen = AntrianPKL::where('status_antrian', 'Menunggu Verifikasi Dokumen')
                                        ->with('dokumen')
                                        ->get();

            return view('admin-instansi.verifikasi-dokumen.index', compact('daftarDokumen'));
        }

        /**
         * Memproses keputusan verifikasi dokumen (Lengkap atau Revisi).
         */
        public function update(Request $request, DokumenPKL $dokumen) // Perhatikan, kita langsung menargetkan model DokumenPkl
        {
            $request->validate([
                'action' => 'required|in:terima,revisi',
                'catatan_revisi' => 'nullable|string|max:1000|required_if:action,revisi',
            ]);

            // Ambil data antrian yang terhubung dengan dokumen ini
            $antrian = $dokumen->antrian;

            if ($request->action === 'terima') {
                // Update tabel dokumen
                $dokumen->update([
                    'status_verifikasi' => 'Diterima',
                    'catatan_revisi' => null,
                ]);
                // Update tabel antrian
                $antrian->update(['status_antrian' => 'Dokumen Lengkap']);
                $message = 'Dokumen untuk ' . $antrian->nama_lengkap . ' telah disetujui.';

            } else { // Jika revisi
                // Update tabel dokumen
                $dokumen->update([
                    'status_verifikasi' => 'Revisi',
                    'catatan_revisi' => $request->catatan_revisi,
                ]);
                // Update tabel antrian
                $antrian->update(['status_antrian' => 'Revisi Dokumen']);
                $message = 'Dokumen untuk ' . $antrian->nama_lengkap . ' ditandai untuk revisi.';
            }

            return redirect()->route('admin-instansi.verifikasi-dokumen.index')->with('success', $message);
        }
}
