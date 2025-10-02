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
        Schema::create('laporan_akhir', function (Blueprint $table) {
            $table->id('id_laporan_akhir');
            $table->unsignedBigInteger('id_penempatan');
            $table->string('judul', 255);
            $table->text('deskripsi_singkat')->nullable();
            $table->string('file_laporan');
            $table->string('status_verifikasi', 100);
            $table->text('feedback')->nullable();
            $table->timestamps();

            $table->foreign('id_penempatan')->references('id_penempatan')->on('penempatan_pkl')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_akhir');
    }
};
