<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\AntrianPKL;
use App\Models\DokumenPKL;
use App\Models\User;
use App\Notifications\PesanNotifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    public function create()
    {
        // 1. Cari antrian PKL milik mahasiswa yang statusnya sudah 'Diterima'
         $antrian = AntrianPKL::where('id_pengguna', Auth::id())
                            ->latest() // Selalu ambil yang paling baru
                            ->first();

        // 2. Cek jika tidak ada antrian sama sekali atau sudah selesai/ditolak
        if (!$antrian || in_array($antrian->status_antrian, ['Ditolak', 'Selesai'])) {
            // Arahkan untuk membuat pengajuan baru.
            return redirect()->route('mahasiswa.pengajuan.antrian')->with('info', 'Silakan ajukan antrian PKL terlebih dahulu untuk bisa mengunggah dokumen.');
        }

        // 3. Logika untuk status yang sedang berjalan
        switch ($antrian->status_antrian) {
            case 'Diterima':
            case 'Revisi Dokumen':
                // Ini adalah kondisi yang TEPAT untuk menampilkan halaman unggah.
                return view('mahasiswa.unggah-dokumen', compact('antrian'));
                // PERBAIKAN: Menghapus 'break;' setelah 'return'

            case 'Menunggu Verifikasi':
                // Jika antrian masih menunggu verifikasi, beri tahu user untuk sabar.
                return redirect()->route('mahasiswa.dashboard')->with('info', 'Pengajuan antrian Anda sedang diverifikasi. Mohon tunggu sebelum mengunggah dokumen.');
                // PERBAIKAN: Menghapus 'break;' setelah 'return'
            
            case 'Menunggu Verifikasi Dokumen':
                // Jika dokumen sudah diunggah dan sedang diverifikasi.
                return redirect()->route('mahasiswa.dashboard')->with('info', 'Dokumen Anda sudah diunggah dan sedang menunggu verifikasi.');
                // PERBAIKAN: Menghapus 'break;' setelah 'return'

            case 'Dokumen Lengkap':
            case 'Ditempatkan':
                // Jika proses unggah dokumen sudah selesai.
                return redirect()->route('mahasiswa.dashboard')->with('info', 'Dokumen Anda telah disetujui. Anda tidak perlu mengunggah ulang.');

            default:
                return redirect()->route('mahasiswa.dashboard')->with('error', 'Terjadi kesalahan. Status pengajuan Anda tidak dikenali.');
        }
    }

    /**
     * Menyimpan file dokumen yang diunggah.
     */
    public function store(Request $request)
    {
        $request->validate([
            'surat_pengantar' => 'required|file|mimes:pdf,docx|max:2048',
            'surat_bankesbangpol' => 'required|file|mimes:pdf,docx|max:2048',
            'antrian_id' => 'required|exists:antrian_pkl,id_antrian',
        ]);

        $antrian = AntrianPKL::findOrFail($request->antrian_id);
        if ($antrian->id_pengguna !== Auth::id()) {
            abort(403, 'Akses Ditolak');
        }
        // Hapus file lama jika ada (untuk kasus revisi)
        if ($antrian->dokumen) {
            Storage::disk('public')->delete($antrian->dokumen->file_surat_pengantar);
            Storage::disk('public')->delete($antrian->dokumen->file_surat_bankesbangpol);
        }

        $pathSuratPengantar = $request->file('surat_pengantar')->store('dokumen_pkl', 'public');
        $pathBankesbangpol = $request->file('surat_bankesbangpol')->store('dokumen_pkl', 'public');

        // Gunakan updateOrCreate, ini akan meng-update jika ada revisi
        DokumenPKL::updateOrCreate(
            ['id_antrian' => $antrian->id_antrian],
            [
                'file_surat_pengantar' => $pathSuratPengantar,
                'file_surat_bankesbangpol' => $pathBankesbangpol,
                'status_verifikasi' => 'Menunggu Verifikasi', // Status kembali ke awal
                'catatan_revisi' => null, // Hapus catatan revisi sebelumnya
            ]
        );

        // Ubah status antrian utama kembali ke 'Menunggu Verifikasi Dokumen'
        $antrian->update(['status_antrian' => 'Menunggu Verifikasi Dokumen']);
        $adminsInstansi = User::where('role', 'admin_instansi')->get();
        $pesan = "Dokumen dari " . $antrian->nama_lengkap . " telah diunggah dan perlu diverifikasi.";
        $url = route('admin-instansi.verifikasi-dokumen.index');

        Notification::send($adminsInstansi, new PesanNotifikasi($pesan, $url));

        return redirect()->route('mahasiswa.dashboard')->with('success', 'Dokumen berhasil diunggah dan sedang menunggu verifikasi.');
    }
}
