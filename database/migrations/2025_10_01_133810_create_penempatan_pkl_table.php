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
        Schema::create('penempatan_pkl', function (Blueprint $table) {
            $table->id('id_penempatan');
            $table->unsignedBigInteger('id_antrian');
            $table->unsignedBigInteger('id_pengguna');
            $table->unsignedBigInteger('id_bidang');
            $table->unsignedBigInteger('id_pembimbing')->nullable();
            $table->string('status_pkl', 100);
            $table->timestamps();

            $table->foreign('id_antrian')->references('id_antrian')->on('antrian_pkl')->onDelete('cascade');
            $table->foreign('id_pengguna')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_bidang')->references('id')->on('bidangs')->onDelete('cascade');
            $table->foreign('id_pembimbing')->references('id')->on('pembimbings')->onDelete(null); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penempatan_pkl');
    }
};
