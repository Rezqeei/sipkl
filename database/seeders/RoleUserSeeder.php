<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin_instansi',
            'email' => 'admininstansi@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'admin_instansi',
        ]);
        User::create([
            'name' => 'admin_bidang',
            'email' => 'adminbidang@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'admin_bidang',
        ]);
        User::create([
            'name' => 'mahasiswa',
            'email' => 'mahasiswa@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
        ]);
    }
}
