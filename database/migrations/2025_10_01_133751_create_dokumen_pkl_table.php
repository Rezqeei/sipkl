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
        Schema::create('dokumen_pkl', function (Blueprint $table) {
             $table->id('id_dokumen');
            $table->unsignedBigInteger('id_antrian');
            $table->string('file_surat_pengantar');
            $table->string('file_surat_bankesbangpol');
            $table->string('status_verifikasi', 100);
            $table->text('catatan_revisi')->nullable();
            $table->timestamps();

            $table->foreign('id_antrian')->references('id_antrian')->on('antrian_pkl')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_pkl');
    }
};
