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

        // Mengambil bidang yang dikelola oleh admin ini melalui relasi
        $bidangDikelola = $adminBidang->bidangDikelola;

        if (!$bidangDikelola) {
            $daftarPengajuan = collect(); // Kirim collection kosong jika tidak ada bidang
        } else {
            // Ambil daftar pengajuan yang menunggu konfirmasi di bidang ini
            // Eager loading untuk efisiensi query
            $daftarPengajuan = PenempatanPKL::with(['antrian.user', 'antrian.dokumen'])
                ->where('id_bidang', $bidangDikelola->id)
                ->where('status_pkl', 'Menunggu Konfirmasi Admin Bidang')
                ->get();
        }

        // Tidak perlu lagi mengirim data pembimbing
        return view('admin-bidang.konfirmasi-mahasiswa', compact('daftarPengajuan'));
    }

    public function prosesKonfirmasi(Request $request, PenempatanPKL $penempatan)
    {
        // Validasi
        $request->validate([
            'action' => 'required|in:terima,tolak',
            'nama_pembimbing' => 'nullable|required_if:action,terima|string|max:255',
            'alasan_penolakan' => 'nullable|required_if:action,tolak|string|max:1000',
        ]);

        $penempatan->load('antrian.user', 'bidang');

        // 2. Lakukan pengecekan untuk mencegah error jika relasi tidak ditemukan
        if (!$penempatan->antrian || !$penempatan->antrian->user) {
            return redirect()->route('admin-bidang.konfirmasi-mahasiswa')->with('error', 'Data mahasiswa terkait tidak ditemukan.');
        }

        // 3. Simpan data ke dalam variabel sebelum diproses lebih lanjut
        $mahasiswa = $penempatan->antrian->user;
        $bidang = $penempatan->bidang;
        $antrian = $penempatan->antrian;

        // --- LOGIKA SELANJUTNYA ---

        if ($request->action === 'terima') {
            // Logika untuk membuat atau menggunakan pembimbing yang sudah ada
            $pembimbing = Pembimbing::firstOrCreate(
                ['nama_pembimbing' => $request->nama_pembimbing]
            );

            // Update data penempatan
            $penempatan->update([
                'status_pkl' => 'Sedang Berjalan',
                'id_pembimbing' => $pembimbing->id,
            ]);

            // Kirim notifikasi ke mahasiswa
            $pesan = "Selamat! Pengajuan PKL Anda di " . $bidang->nama_bidang . " telah diterima. Pembimbing Anda adalah " . $pembimbing->nama_pembimbing . ".";
            $url = route('mahasiswa.dashboard');
            $mahasiswa->notify(new PesanNotifikasi($pesan, $url));

            $message = 'Mahasiswa ' . $mahasiswa->name . ' telah diterima dan sedang menjalankan PKL.';
        } else { // Jika tindakan adalah 'tolak'
            // Kirim notifikasi penolakan ke admin instansi (data sudah aman di variabel)
            $adminsInstansi = User::where('role', 'admin_instansi')->get();
            $pesanAdmin = "Penempatan untuk " . $mahasiswa->name . " di " . $bidang->nama_bidang . " ditolak oleh Admin Bidang. Silakan tempatkan kembali.";
            $urlAdmin = route('admin-instansi.penempatan.index');
            Notification::send($adminsInstansi, new PesanNotifikasi($pesanAdmin, $urlAdmin));

            // Hapus data penempatan
            $penempatan->delete();

            // Kembalikan status antrian mahasiswa
            if ($antrian) {
                $antrian->update(['status_antrian' => 'Dokumen Lengkap']);
            }

            $message = 'Mahasiswa telah ditolak dan dikembalikan ke daftar penempatan Admin Instansi.';
        }

        return redirect()->route('admin-bidang.konfirmasi-mahasiswa')->with('success', $message);
    }
}
