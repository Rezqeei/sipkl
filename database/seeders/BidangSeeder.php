<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BidangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_bidang = User::where('email', 'adminbidang@gmail.com')->first();

        DB::table('bidangs')->delete();
        DB::table('bidangs')->insert([
            [
                'nama_bidang' => 'Infrastruktur dan Teknologi',
                'id_admin_bidang' => $admin_bidang ? $admin_bidang->id : null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_bidang' => 'Aplikasi Informatika',
                'id_admin_bidang' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_bidang' => 'Statistik dan Persandian',
                'id_admin_bidang' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_bidang' => 'Informasi dan Komunikasi Publik',
                'id_admin_bidang' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
