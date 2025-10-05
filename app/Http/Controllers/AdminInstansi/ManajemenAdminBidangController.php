<?php

namespace App\Http\Controllers\AdminInstansi;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; // <-- Import Rule
use Illuminate\Validation\Rules;

class ManajemenAdminBidangController extends Controller
{
    /**
     * Menampilkan daftar semua admin bidang.
     */
    public function index()
    {
        $adminBidangList = User::where('role', 'admin_bidang')->latest()->get();
        return view('admin-instansi.manajemen-admin-bidang', compact('adminBidangList'));
    }

    /**
     * Menampilkan form untuk membuat admin bidang baru.
     */
    public function create()
    {
        return view('admin-instansi.manajemen-admin-bidang.create');
    }

    /**
     * Menyimpan admin bidang baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin_bidang',
            'status_aktif' => true,
        ]);

        // Pastikan nama rute di web.php konsisten (menggunakan strip/hyphen)
        return redirect()->route('admin-instansi.manajemen-admin-bidang.index')->with('success', 'Admin Bidang baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit admin bidang.
     * Menggunakan nama variabel yang lebih ringkas: $admin
     */
    public function edit(User $admin)
    {
        return view('admin-instansi.manajemen-admin-bidang.edit', compact('admin'));
    }

    /**
     * Mengupdate data admin bidang di database.
     */
    public function update(Request $request, User $admin)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // Menggunakan sintaks validasi 'unique' yang lebih modern
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($admin->id)],
            'status_aktif' => ['required', 'boolean'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);
        
        $data = $request->only('name', 'email', 'status_aktif');
        if ($request->filled('password')) { // Gunakan filled() untuk mengecek input tidak kosong
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return redirect()->route('admin-instansi.manajemen-admin-bidang.index')->with('success', 'Data Admin Bidang berhasil diperbarui.');
    }

    /**
     * Menonaktifkan akun admin bidang (Soft Delete).
     */
    public function destroy(User $admin)
    {
        $admin->update(['status_aktif' => false]);
        return redirect()->route('admin-instansi.manajemen-admin-bidang.index')->with('success', 'Admin Bidang berhasil dinonaktifkan.');
    }
}
