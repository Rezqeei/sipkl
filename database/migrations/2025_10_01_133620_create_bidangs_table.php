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
        Schema::create('bidangs', function (Blueprint $table) {
            $table->id();
             $table->string('nama_bidang')->unique();
            $table->unsignedBigInteger('id_admin_bidang')->nullable(); 
            $table->integer('kuota_maksimal')->default(0);
            $table->integer('sisa_kuota')->default(0);
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            $table->foreign('id_admin_bidang')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bidangs');
    }
};
