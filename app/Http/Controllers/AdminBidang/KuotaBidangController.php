<?php

namespace App\Http\Controllers\AdminBidang;

use App\Http\Controllers\Controller;
use App\Models\PenempatanPKL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KuotaBidangController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $bidang = $user->bidangDikelola;

        if (!$bidang) {
            return view('admin-bidang.kuota-bidang', [
                'bidang' => null,
                'mahasiswaAktifCount' => 0,
                'sisaKuota' => 0,
                'mahasiswaAktif' => collect(),
            ]);
        }

        $mahasiswaAktifCount = PenempatanPKL::where('id_bidang', $bidang->id)
            ->where('status_pkl', 'Sedang Berjalan')
            ->count();

        $mahasiswaAktif = PenempatanPKL::with('mahasiswa')
            ->where('id_bidang', $bidang->id)
            ->where('status_pkl', 'Sedang Berjalan')
            ->get();

        $sisaKuota = $bidang->kuota - $mahasiswaAktifCount;

        return view('admin-bidang.kuota-bidang', compact('bidang', 'mahasiswaAktifCount', 'sisaKuota', 'mahasiswaAktif'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $bidang = $user->bidangDikelola;

        if (!$bidang) {
            return redirect()->route('admin-bidang.kuota.index')->with('error', 'Bidang tidak ditemukan.');
        }

        $mahasiswaAktifCount = PenempatanPKL::where('id_bidang', $bidang->id)
            ->where('status_pkl', 'Sedang Berjalan')
            ->count();

        if ($request->kuota < $mahasiswaAktifCount) {
            return back()->withErrors(['kuota' => 'Kuota tidak boleh kurang dari jumlah mahasiswa yang sedang aktif.']);
        }

        $bidang->kuota = $request->kuota;
        $bidang->save();

        return redirect()->route('admin-bidang.kuota-bidang')->with('success', 'Kuota Bidang berhasil diperbarui.');
    }
}
