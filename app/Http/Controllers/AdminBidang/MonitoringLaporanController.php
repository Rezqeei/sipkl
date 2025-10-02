<?php

namespace App\Http\Controllers\AdminBidang;

use App\Http\Controllers\Controller;
use App\Models\LaporanAkhir;
use App\Models\LaporanMingguan;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MonitoringLaporanController extends Controller
{
    public function indexAkhir()
    {
        $admin = Auth::user();
        $bidang = $admin->bidang;

        if (!$bidang) {
            abort(403, 'Akun Anda tidak terhubung ke bidang manapun.');
        }

        $daftarLaporan = LaporanAkhir::where('status_verifikasi', 'Menunggu Verifikasi')
            ->whereHas('penempatan', function ($query) use ($bidang) {
                $query->where('id_bidang', $bidang->id);
            })
            ->with('penempatan.antrian')
            ->latest()
            ->get();
        
        return view('admin-bidang.laporan-akhir', compact('daftarLaporan'));
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
}
