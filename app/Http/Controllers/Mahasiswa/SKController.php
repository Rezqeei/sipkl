<?php

namespace App\Http\Controllers\Mahasiswa;
use App\Models\SuratKeterangan;
use App\Models\PenempatanPkl;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class SKController extends Controller
{
    public function index()
    {
        $penempatan = PenempatanPkl::where('id_pengguna', Auth::id())->first();
        $surat = $penempatan ? SuratKeterangan::where('id_penempatan', $penempatan->id_penempatan)->first() : null;

        return view('mahasiswa.download-sk', compact('surat'));
    }
    public function download(SuratKeterangan $surat)
    {
        $penempatan = PenempatanPkl::find($surat->id_penempatan);
        if ($penempatan->id_pengguna !== Auth::id()) {
            abort(403, 'Akses Ditolak');
        }

        if (!Storage::disk('public')->exists($surat->file_surat)) {
            return redirect()->back()->with('error', 'File Surat Keterangan tidak dapat ditemukan.');
        }
        
        $pathLengkap = Storage::disk('public')->path($surat->file_surat);

        return response()->download($pathLengkap);
    }
}
