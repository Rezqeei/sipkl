<?php

namespace App\Http\Controllers\AdminInstansi;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ManajemenBidangController extends Controller
{
    public function index()
    {
        $bidangs = Bidang::orderBy('nama_bidang')->get();
        return view('admin-instansi.manajemen-bidang', compact('bidangs'));
    }

    public function store(Request $request)
    {
        $request->validate(['nama_bidang' => 'required|unique:bidangs,nama_bidang']);
        Bidang::create(['nama_bidang' => $request->nama_bidang,]);
        return redirect()->route('admin-instansi.manajemen-bidang.index')->with('success', 'Bidang baru berhasil ditambahkan.');
    }

    public function update(Request $request, Bidang $bidang)
    {
        $request->validate([
            'nama_bidang' => [
                'required',
                'string',
                'max:255',
                Rule::unique('bidangs')->ignore($bidang->id),
            ],
        ]);

        $bidang->update([
            'nama_bidang' => $request->nama_bidang,
        ]);

        return redirect()->route('admin-instansi.manajemen-bidang.index')->with('success', 'Nama bidang berhasil diubah.');
    }
    public function destroy(Bidang $bidang)
    {
        if ($bidang->penempatan()->exists()) {
            return redirect()->route('admin-instansi.manajemen-bidang.index')->with('error', 'Gagal! Tidak bisa menghapus bidang karena masih ada mahasiswa yang ditempatkan.');
        }

        $bidang->delete();

        return redirect()->route('admin-instansi.manajemen-bidang.index')->with('success', 'Bidang berhasil dihapus.');
    }
}
