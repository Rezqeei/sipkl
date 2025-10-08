<?php

namespace App\Http\Controllers\Mahasiswa;
use App\Models\SuratKeterangan; // Asumsi model ini ada
use App\Models\PenempatanPkl;
use Illuminate\Http\Request;
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

    /**
     * Memproses download file SK.
     */
    public function download(SuratKeterangan $surat)
    {
        $penempatan = PenempatanPkl::find($surat->id_penempatan);
        if ($penempatan->id_pengguna !== Auth::id()) {
            abort(403, 'Akses Ditolak');
        }

        if (!Storage::disk('public')->exists($surat->file_surat)) {
            return redirect()->back()->with('error', 'File Surat Keterangan tidak dapat ditemukan.');
        }
        // 3. Ambil path lengkap file dari "Gudang"
        $pathLengkap = Storage::disk('public')->path($surat->file_surat);

        // 4. Suruh "Kurir" (response helper) untuk mengirim file dari path tersebut
        return response()->download($pathLengkap);
    }
}
