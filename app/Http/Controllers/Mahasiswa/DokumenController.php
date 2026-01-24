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
        $antrian = AntrianPKL::where('id_pengguna', Auth::id())
            ->latest()
            ->first();

        if (!$antrian || in_array($antrian->status_antrian, ['Ditolak', 'Selesai'])) {
            return redirect()->route('mahasiswa.pengajuan.antrian')->with('info', 'Silakan ajukan antrian PKL terlebih dahulu untuk bisa mengunggah dokumen.');
        }

        switch ($antrian->status_antrian) {
            case 'Diterima':
            case 'Revisi Dokumen':
                return view('mahasiswa.unggah-dokumen', compact('antrian'));


            case 'Menunggu Verifikasi':
                return redirect()->route('mahasiswa.dashboard')->with('info', 'Pengajuan antrian Anda sedang diverifikasi. Mohon tunggu sebelum mengunggah dokumen.');


            case 'Menunggu Verifikasi Dokumen':
                return redirect()->route('mahasiswa.dashboard')->with('info', 'Dokumen Anda sudah diunggah dan sedang menunggu verifikasi.');

            case 'Dokumen Lengkap':
            case 'Ditempatkan':
                return redirect()->route('mahasiswa.dashboard')->with('info', 'Dokumen Anda telah disetujui. Anda tidak perlu mengunggah ulang.');

            default:
                return redirect()->route('mahasiswa.dashboard')->with('error', 'Terjadi kesalahan. Status pengajuan Anda tidak dikenali.');
        }
    }

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

        if ($antrian->dokumen) {
            Storage::disk('public')->delete($antrian->dokumen->file_surat_pengantar);
            Storage::disk('public')->delete($antrian->dokumen->file_surat_bankesbangpol);
        }

        $pathSuratPengantar = $request->file('surat_pengantar')->store('dokumen_pkl', 'public');
        $pathBankesbangpol = $request->file('surat_bankesbangpol')->store('dokumen_pkl', 'public');

        DokumenPKL::updateOrCreate(
            ['id_antrian' => $antrian->id_antrian],
            [
                'file_surat_pengantar' => $pathSuratPengantar,
                'file_surat_bankesbangpol' => $pathBankesbangpol,
                'status_verifikasi' => 'Menunggu Verifikasi',
                'catatan_revisi' => null,
            ]
        );

        $antrian->update(['status_antrian' => 'Menunggu Verifikasi Dokumen']);
        $adminsInstansi = User::where('role', 'admin_instansi')->get();
        $pesan = "Dokumen dari mahasiswa {$antrian->user->name} telah diunggah dan menunggu verifikasi.";
        $url = route('admin-instansi.verifikasi-dokumen.index');

        Notification::send($adminsInstansi, new PesanNotifikasi($pesan, $url));

        return redirect()->route('mahasiswa.dashboard')->with('success', 'Dokumen berhasil diunggah dan sedang menunggu verifikasi.');
    }
}
