<?php

namespace App\Http\Controllers\AdminBidang;

use App\Http\Controllers\Controller;
use App\Models\LaporanAkhir;
use App\Models\LaporanMingguan;
use App\Models\PenempatanPKL;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MonitoringLaporanController extends Controller
{
    public function mingguan()
    {
        // 1. Dapatkan admin bidang yang sedang login.
        $admin = Auth::user();
        // 2. Dapatkan bidang yang dikelola oleh admin ini.
        $bidang = $admin->bidang;

        // Siapkan koleksi kosong sebagai nilai default jika admin tidak terhubung ke bidang manapun.
        $laporanMingguan = collect();

        // 3. Jika admin terhubung ke sebuah bidang, cari laporan mahasiswa di bidang itu.
        if ($bidang) {
            // Dapatkan semua ID mahasiswa yang ditempatkan di bidang ini
            $mahasiswaIds = PenempatanPKL::where('bidang_id', $bidang->id)->pluck('user_id');

            // Dapatkan semua laporan mingguan dari mahasiswa-mahasiswa tersebut,
            // diurutkan dari yang terbaru, dan sertakan data user (mahasiswa) nya.
            if ($mahasiswaIds->isNotEmpty()) {
                $laporanMingguan = LaporanMingguan::with('user')
                    ->whereIn('user_id', $mahasiswaIds)
                    ->latest() // Mengurutkan dari yang terbaru
                    ->get();
            }
        }

        // 4. Tampilkan view 'laporan-mingguan' dan kirim data laporannya.
        return view('admin-bidang.laporan-mingguan', compact('laporanMingguan'));
    }
    public function akhir()
    {
        $admin = Auth::user();
        $bidang = $admin->bidang;
        $laporanAkhir = collect();

        // 3. Jika admin terhubung ke sebuah bidang, cari laporan mahasiswa di bidang itu.
        if ($bidang) {
            // Dapatkan semua ID mahasiswa yang ditempatkan di bidang ini.
            $mahasiswaIds = PenempatanPKL::where('bidang_id', $bidang->id)->pluck('user_id');

            // Jika ada mahasiswa, ambil semua laporan akhir mereka.
            if ($mahasiswaIds->isNotEmpty()) {
                $laporanAkhir = LaporanAkhir::with('user')
                    ->whereIn('user_id', $mahasiswaIds)
                    ->latest()
                    ->get();
            }
        }

        // 4. Tampilkan view 'laporan-akhir' dan kirim data laporannya.
        return view('admin-bidang.laporan-akhir', compact('laporanAkhir'));
    }

    /**
     * Memproses keputusan verifikasi laporan akhir.
     */
    public function updateAkhir(Request $request, LaporanAkhir $laporan_akhir)
    {
        // Otorisasi
        if (Auth::user()->bidang->id !== $laporan_akhir->penempatan->id_bidang) {
            throw new AuthorizationException;
        }

        $request->validate([
            'action' => 'required|in:setuju,revisi',
            'feedback' => 'nullable|string|max:1000|required_if:action,revisi',
        ]);

        if ($request->action === 'setuju') {
            $laporan_akhir->update([
                'status_verifikasi' => 'Diterima',
                'feedback' => null,
            ]);

            // PENTING: Ubah status PKL mahasiswa menjadi 'Selesai'
            $laporan_akhir->penempatan->update(['status_pkl' => 'Selesai']);


            $message = 'Laporan akhir telah disetujui dan PKL mahasiswa telah ditandai selesai.';
        } else {
            $laporan_akhir->update([
                'status_verifikasi' => 'Revisi',
                'feedback' => $request->feedback,
            ]);
            $message = 'Laporan akhir ditandai untuk revisi.';
        }

        return redirect()->back()->with('success', $message);
    }
     public function download($id)
    {
        // Mencoba mencari di LaporanAkhir dulu
        $laporan = LaporanAkhir::find($id);
        $disk = 'private'; // Asumsi laporan akhir di disk private

        // Jika tidak ketemu di LaporanAkhir, cari di LaporanMingguan
        if (!$laporan) {
            $laporan = LaporanMingguan::find($id);
        }

        // Jika laporan (baik akhir maupun mingguan) ditemukan
        if ($laporan) {
            $filePath = $laporan->file_path ?? $laporan->file_laporan;
            
            if (Storage::disk($disk)->exists($filePath)) {
                $fileName = $laporan->nama_file ?? basename($filePath);
                // Menggunakan helper response()->download() dengan path absolut dari Storage
                return response()->download(Storage::disk($disk)->path($filePath), $fileName);
            }
        }
        return redirect()->back()->with('error', 'File laporan tidak ditemukan.');
    }
}
