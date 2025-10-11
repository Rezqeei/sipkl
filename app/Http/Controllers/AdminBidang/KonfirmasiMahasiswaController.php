<?php

namespace App\Http\Controllers\AdminBidang;

use App\Http\Controllers\Controller;
use App\Models\AntrianPKL;
use App\Models\Bidang;
use App\Models\Pembimbing;
use App\Models\PenempatanPKL;
use App\Models\User;
use App\Notifications\PesanNotifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class KonfirmasiMahasiswaController extends Controller
{
    public function index()
    {
        $adminBidang = Auth::user();
        $bidangDikelola = $adminBidang->bidangDikelola;

        if (!$bidangDikelola) {
            $daftarPengajuan = collect();
        } else {
            $daftarPengajuan = PenempatanPKL::with(['antrian.user', 'antrian.dokumen'])
                ->where('id_bidang', $bidangDikelola->id)
                ->where('status_pkl', 'Menunggu Konfirmasi Admin Bidang')
                ->get();
        }

        return view('admin-bidang.konfirmasi-mahasiswa', compact('daftarPengajuan'));
    }

    public function prosesKonfirmasi(Request $request, PenempatanPKL $penempatan)
    {
        $request->validate([
            'action' => 'required|in:terima,tolak',
            'nama_pembimbing' => 'nullable|required_if:action,terima|string|max:255',
            'alasan_penolakan' => 'nullable|required_if:action,tolak|string|max:1000',
        ]);

        $penempatan->load('antrian.user', 'bidang');

        if (!$penempatan->antrian || !$penempatan->antrian->user) {
            return redirect()->route('admin-bidang.konfirmasi-mahasiswa')->with('error', 'Data mahasiswa terkait tidak ditemukan.');
        }

        $mahasiswa = $penempatan->antrian->user;
        $bidang = $penempatan->bidang;
        $antrian = $penempatan->antrian;

        if ($request->action === 'terima') {
            $pembimbing = Pembimbing::firstOrCreate(
                ['nama_pembimbing' => $request->nama_pembimbing]
            );

            $penempatan->update([
                'status_pkl' => 'Sedang Berjalan',
                'id_pembimbing' => $pembimbing->id,
            ]);

            $pesan = "Selamat! Pengajuan PKL Anda di " . $bidang->nama_bidang . " telah diterima. Pembimbing Anda adalah " . $pembimbing->nama_pembimbing . ".";
            $url = route('mahasiswa.dashboard');
            $mahasiswa->notify(new PesanNotifikasi($pesan, $url));

            $message = 'Mahasiswa ' . $mahasiswa->name . ' telah diterima dan sedang menjalankan PKL.';
        } else {
            $adminsInstansi = User::where('role', 'admin_instansi')->get();
            $pesanAdmin = "Penempatan untuk " . $mahasiswa->name . " di " . $bidang->nama_bidang . " ditolak oleh Admin Bidang. Silakan tempatkan kembali.";
            $urlAdmin = route('admin-instansi.penempatan.index');
            Notification::send($adminsInstansi, new PesanNotifikasi($pesanAdmin, $urlAdmin));

            $penempatan->delete();

            if ($antrian) {
                $antrian->update(['status_antrian' => 'Dokumen Lengkap']);
            }

            $message = 'Mahasiswa telah ditolak dan dikembalikan ke daftar penempatan Admin Instansi.';
        }

        return redirect()->route('admin-bidang.konfirmasi-mahasiswa')->with('success', $message);
    }
}
