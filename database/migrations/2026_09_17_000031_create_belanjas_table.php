<?php

// Migrasi tabel belanjas - pakai dana untuk kegiatan per bidang

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Buat tabel belanjas + relasi ke danas
    public function up(): void
    {
        Schema::create('belanjas', function (Blueprint $table) {
            $table->id();
            // Dana yang dipakai; ikut terhapus jika dana dihapus
            $table->foreignId('dana_id')->constrained('danas')->cascadeOnDelete();
            // Bidang kegiatan, mis. Pelaksanaan Pembangunan
            $table->string('bidang');
            // Uraian pemakaian dana
            $table->string('uraian');
            // Nominal terpakai dalam rupiah
            $table->unsignedBigInteger('nominal')->default(0);
            $table->timestamps();
        });
    }

    // Kembalikan: hapus tabel belanjas
    public function down(): void
    {
        Schema::dropIfExists('belanjas');
    }
};
