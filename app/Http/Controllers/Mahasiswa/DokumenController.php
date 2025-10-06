<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\AntrianPKL;
use App\Models\DokumenPKL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    public function create()
    {
        // 1. Cari antrian PKL milik mahasiswa yang statusnya sudah 'Diterima'
        $antrian = AntrianPkl::where('id_pengguna', Auth::id())
            ->where('status_antrian', ['Diterima', 'Revisi Dokumen'])
            ->first();

        // 2. Jika tidak ditemukan, jangan izinkan akses ke halaman upload
        if (!$antrian) {
            // Cek apakah ada pengajuan lain yang sedang aktif untuk memberikan pesan yang lebih sesuai
            $pengajuanAktif = AntrianPkl::where('id_pengguna', Auth::id())
                ->whereNotIn('status_antrian', ['Ditolak', 'Selesai', 'Revisi Dokumen'])
                ->exists();
            if ($pengajuanAktif) {
                return redirect()->route('mahasiswa.dashboard')->with('error', 'Anda belum bisa mengunggah dokumen. Mohon tunggu proses verifikasi antrian selesai.');
            }
            // Jika tidak ada pengajuan sama sekali, arahkan untuk membuat pengajuan
            return redirect()->route('mahasiswa.pengajuan.antrian')->with('error', 'Silakan ajukan antrian PKL terlebih dahulu sebelum mengunggah dokumen.');
        }

        // Jika ditemukan, tampilkan view dan kirim data antrian
        return view('mahasiswa.unggah-dokumen', compact('antrian'));
    }

    /**
     * Menyimpan file dokumen yang diunggah.
     */
    public function store(Request $request)
    {
        // 1. Validasi request untuk kedua file
        $request->validate([
            'surat_pengantar' => 'required|file|mimes:pdf,docx|max:2048',
            'surat_bankesbangpol' => 'required|file|mimes:pdf,docx|max:2048',
            'antrian_id' => 'required|exists:antrian_pkl,id_antrian',
        ]);

        // 2. Cek otorisasi, pastikan antrian ini milik user yang login
        $antrian = AntrianPkl::findOrFail($request->antrian_id);
        if ($antrian->dokumen) {
            Storage::disk('public')->delete($antrian->dokumen->file_surat_pengantar);
            Storage::disk('public')->delete($antrian->dokumen->file_surat_bankesbangpol);
        }

        // 3. Proses upload kedua file ke folder storage/app/public/dokumen_pkl
        $pathSuratPengantar = $request->file('surat_pengantar')->store('dokumen_pkl', 'public');
        $pathBankesbangpol = $request->file('surat_bankesbangpol')->store('dokumen_pkl', 'public');

        // 4. Simpan path file ke database
        DokumenPkl::updateOrCreate(
            ['id_antrian' => $antrian->id_antrian], 
            [
                'file_surat_pengantar' => $pathSuratPengantar,
                'file_surat_bankesbangpol' => $pathBankesbangpol,
                'status_verifikasi' => 'Menunggu Verifikasi',
                'catatan_revisi' => null,
            ]
        );

        // 5. Ubah status antrian utama
        $antrian->update(['status_antrian' => 'Menunggu Verifikasi Dokumen']);

        // 6. Redirect dengan pesan sukses
        return redirect()->route('mahasiswa.dashboard')->with('success', 'Dokumen berhasil diunggah dan sedang menunggu verifikasi.');
    }
}
