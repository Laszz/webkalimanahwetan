<?php

// Migrasi tabel tanggapan_aduans - balasan admin atas laporan warga

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Buat tabel tanggapan_aduans + relasi aduan dan penanggap
    public function up(): void
    {
        Schema::create('tanggapan_aduans', function (Blueprint $table) {
            $table->id();
            // Aduan yang ditanggapi; ikut terhapus jika aduan dihapus
            $table->foreignId('aduan_id')->constrained('aduans')->cascadeOnDelete();
            // Admin penanggap; ikut terhapus jika user dihapus
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // Isi tanggapan
            $table->text('isi');
            $table->timestamps();
        });
    }

    // Kembalikan: hapus tabel tanggapan_aduans
    public function down(): void
    {
        Schema::dropIfExists('tanggapan_aduans');
    }
};
