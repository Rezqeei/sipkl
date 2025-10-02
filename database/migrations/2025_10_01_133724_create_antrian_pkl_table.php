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
        Schema::create('antrian_pkl', function (Blueprint $table) {
            $table->id('id_antrian');
            $table->unsignedBigInteger('id_pengguna');
            $table->string('nim', 15);
            $table->string('jurusan', 100);
            $table->string('nama_kampus', 255);
            $table->string('alamat', 255)->nullable();
            $table->integer('jumlah_orang')->default(1);
            $table->date('tgl_mulai');
            $table->date('tgl_berakhir');
            $table->string('kontak_aktif', 15);
            $table->string('status_antrian', 100);
            $table->text('alasan_penolakan')->nullable();
            $table->timestamps();

            $table->foreign('id_pengguna')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antrian_pkl');
    }
};
