<?php

namespace Database\Seeders;

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
        DB::table('bidangs')->truncate();

            // Masukkan data bidang yang ada di Diskominfo
            DB::table('bidangs')->insert([
                ['nama_bidang' => 'Infrastruktur dan Teknologi', 'kuota_maksimal' => 5, 'sisa_kuota' => 5],
                ['nama_bidang' => 'Aplikasi Informatika', 'kuota_maksimal' => 10, 'sisa_kuota' => 10],
                ['nama_bidang' => 'Statistik dan Persandian', 'kuota_maksimal' => 3, 'sisa_kuota' => 3],
                ['nama_bidang' => 'Informasi dan Komunikasi Publik', 'kuota_maksimal' => 4, 'sisa_kuota' => 4],
                ['nama_bidang' => 'Sekretariat', 'kuota_maksimal' => 5, 'sisa_kuota' => 5],
            ]);
    }
}
