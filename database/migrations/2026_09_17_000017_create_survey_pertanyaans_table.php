<?php

// Migrasi tabel survey_pertanyaans - butir pertanyaan tiap survei

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Buat tabel survey_pertanyaans + relasi ke surveys
    public function up(): void
    {
        Schema::create('survey_pertanyaans', function (Blueprint $table) {
            $table->id();
            // Survei pemilik pertanyaan; ikut terhapus jika survei dihapus
            $table->foreignId('survey_id')->constrained('surveys')->cascadeOnDelete();
            // Teks pertanyaan
            $table->text('pertanyaan');
            // Bentuk jawaban: skala 1-5 atau tulisan bebas
            $table->enum('tipe', ['skala', 'text'])->default('skala');
            // Wajib dijawab atau boleh kosong
            $table->boolean('wajib')->default(true);
            // Nomor urut tampil di form survei
            $table->unsignedSmallInteger('urutan')->default(0);
            $table->timestamps();

            // Indeks gabungan: pertanyaan selalu diambil per survei berurutan nomor tampil
            $table->index(['survey_id', 'urutan']);
        });
    }

    // Kembalikan: hapus tabel survey_pertanyaans
    public function down(): void
    {
        Schema::dropIfExists('survey_pertanyaans');
    }
};
