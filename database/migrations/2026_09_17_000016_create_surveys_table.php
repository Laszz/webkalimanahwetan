<?php

// Migrasi tabel surveys - daftar survei kepuasan pegawai/layanan desa

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Buat tabel surveys
    public function up(): void
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            // Judul survei, mis. kepuasan pelayanan KTP
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            // Nonaktif = tidak tampil di daftar survei warga
            $table->boolean('aktif')->default(true);
            // Periode pengisian; kosong = selalu terbuka
            $table->dateTime('mulai')->nullable();
            $table->dateTime('selesai')->nullable();
            $table->timestamps();

            // Indeks kolom aktif: query utama warga selalu saring survei yang dibuka
            $table->index('aktif');
        });
    }

    // Kembalikan: hapus tabel surveys
    public function down(): void
    {
        Schema::dropIfExists('surveys');
    }
};
