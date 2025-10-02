<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'name' => 'Admin Instansi',
            'email' => 'admininstansi@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'admin_instansi',
        ]);
        User::create([
            'name' => 'Admin Bidang TI',
            'email' => 'adminbidang@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'admin_bidang',
        ]);
        User::create([
            'name' => 'Mahasiswa',
            'email' => 'mahasiswa@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
        ]);
    }
}
