<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\LaporanAkhir;
use App\Models\LaporanMingguan;
use App\Models\PenempatanPKL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanPKLController extends Controller
{
    public function createAkhir()
    {
        $penempatan = PenempatanPkl::where('id_pengguna', Auth::id())
                                   ->where('status_pkl', 'Sedang Berjalan')
                                   ->with('laporanAkhir')
                                   ->first();
        if (!$penempatan) {
            return redirect()->route('mahasiswa.dashboard')->with('error', 'Anda tidak dapat mengunggah laporan saat ini.');
        }
        return view('mahasiswa.laporan-akhir', compact('penempatan'));
    }

    /**
     * Menyimpan data laporan akhir yang diunggah.
     */
    public function storeAkhir(Request $request)
    {
        $request->validate(['file_laporan_akhir' => 'required|file|mimes:pdf,docx|max:10240']); // maks 10MB
        
        $penempatan = PenempatanPkl::where('id_pengguna', Auth::id())->firstOrFail();
        $path = $request->file('file_laporan_akhir')->store('laporan_akhir', 'public');

        // Gunakan updateOrCreate untuk mencegah duplikasi
        LaporanAkhir::updateOrCreate(
            ['id_penempatan' => $penempatan->id_penempatan],
            [
                'file_laporan' => $path,
                'status_verifikasi' => 'Menunggu Verifikasi',
            ]
        );

        return redirect()->back()->with('success', 'Laporan akhir berhasil diunggah.');
    }
}
