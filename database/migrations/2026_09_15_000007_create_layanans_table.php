<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('layanans', function (Blueprint $table) {
            $table->id();
            // Nama layanan, mis. KTP, Domisili, SKTM
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            // Estimasi selesai dalam hari kerja
            $table->unsignedSmallInteger('estimasi_hari')->nullable();
            // Nonaktif = tidak tampil di halaman layanan
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanans');
    }
};
