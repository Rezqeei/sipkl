<?php

namespace App\Http\Controllers\AdminBidang;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use App\Models\PenempatanPKL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KonfirmasiMahasiswaController extends Controller
{
    public function index()
    {
        $adminBidang = Auth::user();
        
        
        $bidang = Bidang::where('id_admin_bidang', $adminBidang->id)->first();

        if (!$bidang) {
            return view('admin-bidang.konfirmasi-mahasiswa')->with('error', 'Akun Anda belum terhubung dengan Bidang manapun.');
        }

        
        $daftarPengajuan = PenempatanPKL::with('antrian.user')
                                        ->where('id_bidang', $bidang->id)
                                        ->where('status_pkl', 'Menunggu Konfirmasi Admin Bidang')
                                        ->get();

        return view('admin-bidang.konfirmasi-mahasiswa', compact('daftarPengajuan', 'bidang'));
    }
    public function prosesKonfirmasi(Request $request, PenempatanPKL $penempatan)
    {
        $request->validate([
            'action' => 'required|in:terima,tolak',
            'id_pembimbing' => 'required_if:action,terima|exists:pembimbings,id', 
            'alasan_penolakan' => 'nullable|required_if:action,tolak|string',
        ]);
        
        $bidang = $penempatan->bidang; 

        if ($request->action == 'terima') {
            
            if ($bidang->sisa_kuota < $penempatan->antrian->jumlah_orang) {
                
                return back()->with('error', 'Penolakan otomatis: Kuota Bidang tidak mencukupi.');
            }

            
            $penempatan->update([
                'status_pkl' => 'Sedang Berjalan',
                'id_pembimbing' => $request->id_pembimbing,
            ]);

            
            $bidang->decrement('sisa_kuota', $penempatan->antrian->jumlah_orang);
            
            
            $message = 'Mahasiswa Diterima di Bidang ini. PKL Sedang Berjalan.';
        } else {
            
            $penempatan->update([
                'status_pkl' => 'Ditolak - Kuota Penuh', 
                'alasan_penolakan' => $request->alasan_penolakan,
            ]);
            
          
            $message = 'Mahasiswa Ditolak dari Bidang ini. Admin Instansi akan menindaklanjuti.';
        }

        return redirect()->route('admin_bidang.konfirmasi-mahasiswa')->with('success', $message);
    }
}
