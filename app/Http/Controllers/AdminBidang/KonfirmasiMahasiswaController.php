<?php

namespace App\Http\Controllers\AdminBidang;

use App\Http\Controllers\Controller;
use App\Models\AntrianPKL;
use App\Models\Bidang;
use App\Models\Pembimbing;
use App\Models\PenempatanPKL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            // Nama pembimbing hanya wajib jika aksinya 'terima'
            'nama_pembimbing' => 'nullable|required_if:action,terima|string|max:255',
            // Alasan penolakan hanya wajib jika aksinya 'tolak'
            'alasan_penolakan' => 'nullable|required_if:action,tolak|string|max:1000',
        ]);

        if ($request->action === 'terima') {
            // Logika cerdas untuk membuat atau menggunakan pembimbing yang sudah ada
            $pembimbing = Pembimbing::firstOrCreate(
                ['nama_pembimbing' => $request->nama_pembimbing]
            );

            // Update data penempatan
            $penempatan->update([
                'status_pkl' => 'Sedang Berjalan', // Status diubah menjadi "Sedang Berjalan"
                'id_pembimbing' => $pembimbing->id, // Gunakan ID pembimbing yang sudah didapat
            ]);

            $message = 'Mahasiswa ' . $penempatan->antrian->user->name . ' telah diterima dan sedang menjalankan PKL.';
        } else { // Jika aksinya 'tolak'
            // 1. Hapus record penempatannya
            $penempatan->delete();

            // 2. Kembalikan status antrian utama menjadi 'Dokumen Lengkap'
            // agar muncul lagi di halaman penempatan Admin Instansi
            $antrian = AntrianPKL::find($penempatan->id_antrian);
            if ($antrian) {
                $antrian->update(['status_antrian' => 'Dokumen Lengkap']);
            }

            // (Opsional) Simpan alasan penolakan jika perlu, misalnya di log atau tabel terpisah.
            // Untuk saat ini kita langsung kembalikan saja.

            $message = 'Mahasiswa telah ditolak dan dikembalikan ke daftar penempatan Admin Instansi.';
        }

        return redirect()->route('admin-bidang.konfirmasi-mahasiswa')->with('success', $message);
    }
}
