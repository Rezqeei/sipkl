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
        Schema::create('surat_keterangan', function (Blueprint $table) {
            $table->id('id_surat');
            $table->unsignedBigInteger('id_penempatan');
            $table->string('nomor_surat');
            $table->date('tanggal_terbit');
            $table->string('file_surat'); // Path file PDF SK
            $table->timestamps();

            $table->foreign('id_penempatan')->references('id_penempatan')->on('penempatan_pkl')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keterangan');
    }
};
