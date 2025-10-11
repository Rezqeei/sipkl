<?php

namespace App\Http\Controllers\AdminInstansi;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class ManajemenAdminBidangController extends Controller
{
    public function index()
    {
        $adminBidangList = User::where('role', 'admin_bidang')->with('bidangDikelola')->latest()->get();
        $bidangs = Bidang::with('adminBidang')->orderBy('nama_bidang')->get();
        $allBidangsForModal = Bidang::orderBy('nama_bidang')->get();
        return view('admin-instansi.manajemen-admin-bidang', compact('adminBidangList', 'bidangs', 'allBidangsForModal'));
    }
    public function create()
    {
        return view('admin-instansi.manajemen-admin-bidang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'id_bidang' => ['nullable', 'exists:bidangs,id'],
        ]);
        if ($request->filled('id_bidang')) {
            $bidang = Bidang::find($request->id_bidang);
            if ($bidang && $bidang->id_admin_bidang) {
                return back()->withInput()->with('error', 'Gagal! Bidang "' . $bidang->nama_bidang . '" sudah memiliki admin.');
            }
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin_bidang',
            'status_aktif' => true,
        ]);

        if ($request->filled('id_bidang')) {
            $bidangToUpdate = Bidang::find($request->id_bidang);
            $bidangToUpdate->id_admin_bidang = $user->id;
            $bidangToUpdate->save();
        }

        return redirect()->route('admin-instansi.manajemen-admin-bidang.index')->with('success', 'Admin Bidang baru berhasil ditambahkan.');
    }
    public function edit(User $admin)
    {
        return view('admin-instansi.manajemen-admin-bidang.edit', compact('admin'));
    }

    public function update(Request $request, User $manajemen_admin_bidang)
    {
        $admin = $manajemen_admin_bidang;
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($admin->id)],
            'status_aktif' => ['required', 'boolean'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'id_bidang' => ['nullable', 'exists:bidangs,id'],
        ]);

        if ($request->filled('id_bidang')) {
            $bidang = Bidang::find($request->id_bidang);
            if ($bidang && $bidang->id_admin_bidang && $bidang->id_admin_bidang !== $admin->id) {
                return back()->with('error', 'Gagal! Bidang "' . $bidang->nama_bidang . '" sudah dipegang oleh admin lain.');
            }
        }

        $data = $request->only('name', 'email', 'status_aktif');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        Bidang::where('id_admin_bidang', $admin->id)->update(['id_admin_bidang' => null]);

        if ($request->filled('id_bidang')) {
            $bidangToUpdate = Bidang::find($request->id_bidang);
            $bidangToUpdate->update(['id_admin_bidang' => $admin->id]);
        }

        return redirect()->route('admin-instansi.manajemen-admin-bidang.index')->with('success', 'Data Admin Bidang berhasil diperbarui.');
    }
    public function destroy(User $manajemen_admin_bidang)
    {
        $admin = $manajemen_admin_bidang;

        if ($admin->bidangDikelola) {
            $admin->bidangDikelola->update(['id_admin_bidang' => null]);
        }

        $admin->delete();

        return redirect()->route('admin-instansi.manajemen-admin-bidang.index')->with('success', 'Akun Admin Bidang berhasil dihapus.');
    }
}
