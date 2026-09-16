<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_layanans', function (Blueprint $table) {
            $table->id();
            // Pemohon; ikut terhapus jika user dihapus
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // Layanan yang diajukan; ikut terhapus jika layanan dihapus
            $table->foreignId('layanan_id')->constrained('layanans')->cascadeOnDelete();
            // Keperluan pengajuan, mis. melamar pekerjaan
            $table->text('keperluan')->nullable();
            // Alur status: menunggu -> diproses -> selesai / ditolak
            $table->enum('status', ['menunggu', 'diproses', 'selesai', 'ditolak'])->default('menunggu')->index();
            // Catatan admin, mis. alasan penolakan
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Indeks gabungan untuk filter riwayat per warga per status
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_layanans');
    }
};
