<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('antrian_pkl', function (Blueprint $table) {
            Schema::table('antrian_pkl', function (Blueprint $table) {
                $table->string('kontak_aktif')->nullable()->change();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('antrian_pkl', function (Blueprint $table) {
            //
        });
    }
};
