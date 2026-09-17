<?php

// Migrasi tabel template_hasil_layanans - format dokumen hasil per jenis layanan

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Buat tabel template_hasil_layanans + relasi ke layanans
    public function up(): void
    {
        Schema::create('template_hasil_layanans', function (Blueprint $table) {
            $table->id();
            // Satu layanan satu template; ikut terhapus jika layanan dihapus
            $table->foreignId('layanan_id')
                ->unique()
                ->constrained('layanans')
                ->cascadeOnDelete();
            // Path file template Word di storage private (diakses via backend + otorisasi)
            $table->string('file_path');
            // Nonaktif = template tidak dipakai generate dokumen
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    // Kembalikan: hapus tabel template_hasil_layanans
    public function down(): void
    {
        Schema::dropIfExists('template_hasil_layanans');
    }
};
