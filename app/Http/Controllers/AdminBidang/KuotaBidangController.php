<?php

namespace App\Http\Controllers\AdminBidang;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use App\Models\PenempatanPKL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KuotaBidangController extends Controller
{
    /**
     * Menampilkan halaman informasi kuota dan daftar mahasiswa aktif.
     */
    public function index()
    {
        // --- PROBLEM SOLVING LOGIC ---
        // 1. Mengambil data admin bidang yang sedang login.
        $admin = Auth::user();
        // 2. Mengambil data bidang yang terhubung dengan admin tersebut.
        $bidang = $admin->bidang; // Menggunakan relasi 'bidang' dari model User.php

        $jumlahMahasiswa = 0;
        if ($bidang) {
            $jumlahMahasiswa = PenempatanPKL::where('bidang_id', $bidang->id)->count();
        }

        // 3. Mengirimkan variabel $bidang dan $jumlahMahasiswa ke view.
        // Ini akan mengatasi error "Undefined variable $bidang".
        return view('admin-bidang.kuota-bidang', compact('bidang', 'jumlahMahasiswa'));
    }

    /**
     * Mengupdate kuota maksimal dan sisa kuota bidang.
     */
    public function update(Request $request)
    {
        $admin = Auth::user();
        $bidang = $admin->bidang;

        if (!$bidang) {
            return back()->with('error', 'Tidak dapat memperbarui kuota. Bidang tidak ditemukan.');
        }

        $request->validate([
            'kuota_maksimal' => 'required|integer|min:0',
        ]);

        // Hitung jumlah total mahasiswa aktif di bidang ini (dari kolom 'jumlah_orang')
        // Query ini jauh lebih cepat daripada iterasi collection
        $jumlahMahasiswaAktif = $bidang->penempatan()
            ->where('status_pkl', 'Sedang Berjalan')
            ->withSum('antrian', 'jumlah_orang')
            ->get()
            ->sum('antrian_sum_jumlah_orang');

        $kuota_maksimal_baru = $request->kuota_maksimal;

        // Logika validasimu yang cerdas kita pertahankan
        if ($kuota_maksimal_baru < $jumlahMahasiswaAktif) {
            return back()->with('error', 'Kuota Maksimal tidak valid! Jumlah mahasiswa aktif (' . $jumlahMahasiswaAktif . ' orang) melebihi kuota baru.');
        }

        $sisa_kuota_baru = $kuota_maksimal_baru - $jumlahMahasiswaAktif;

        // Update data di database
        $bidang->update([
            'kuota_maksimal' => $kuota_maksimal_baru,
            'sisa_kuota' => $sisa_kuota_baru,
        ]);

        return redirect()->route('admin-bidang.kuota-bidang.index')->with('success', 'Kuota Bidang berhasil diperbarui.');
    }
}
