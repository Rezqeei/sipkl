<?php

namespace App\Http\Controllers\AdminInstansi;

use App\Http\Controllers\Controller;
use App\Models\AntrianPKL;
use App\Models\DokumenPKL;
use App\Notifications\PesanNotifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VerifikasiDokumenController extends Controller
{
    public function index()
    {
        $daftarDokumen = AntrianPKL::where('status_antrian', 'Menunggu Verifikasi Dokumen')
            ->with('dokumen', 'user')
            ->get();

        return view('admin-instansi.verifikasi-dokumen', compact('daftarDokumen'));
    }

    public function update(Request $request, DokumenPKL $dokumen) 
    {
        $request->validate([
            'action' => 'required|in:terima,revisi',
            'catatan_revisi' => 'nullable|string|max:1000|required_if:action,revisi',
        ]);

        $antrian = $dokumen->antrian;
        $mahasiswa = $antrian->user;

        if ($request->action === 'terima') {
            $dokumen->update([
                'status_verifikasi' => 'Diterima',
                'catatan_revisi' => null,
            ]);
            $antrian->update(['status_antrian' => 'Dokumen Lengkap']);
            $message = 'Dokumen untuk ' . $antrian->user->name . ' telah disetujui.';

            $pesan = "Selamat, Dokumen Persyaratan Anda Disetujui, selanjutnya silahkan menunggu informasi lebih lanjut.";
            $url = route('mahasiswa.dashboard');
            $mahasiswa->notify(new PesanNotifikasi($pesan, $url));
        } else {
            $dokumen->update([
                'status_verifikasi' => 'Revisi',
                'catatan_revisi' => $request->catatan_revisi,
            ]);

            $antrian->update(['status_antrian' => 'Revisi Dokumen']);
            $message = 'Dokumen untuk ' . $antrian->user->name . ' ditandai untuk revisi.';

            $pesan = "Dokumen Persyaratan Anda perlu direvisi. Silakan periksa catatan dan unggah kembali. Catatan: {$request->catatan_revisi}";
            $url = route('mahasiswa.unggah.dokumen');
            $mahasiswa->notify(new PesanNotifikasi($pesan, $url));
        }

        return redirect()->route('admin-instansi.verifikasi-dokumen.index')->with('success', $message);
    }
    public function download(DokumenPKL $dokumen, $tipe)
    {
        $path = null;
        if ($tipe === 'pengantar') {
            $path = $dokumen->file_surat_pengantar;
        } elseif ($tipe === 'bankesbangpol') {
            $path = $dokumen->file_surat_bankesbangpol;
        }

        if ($path && Storage::disk('public')->exists($path)) {
            $fullPath = storage_path('app/public/' . $path);
            return response()->download($fullPath);
        }

        return back()->with('error', 'File tidak ditemukan atau tidak dapat diakses.');
    }
}
