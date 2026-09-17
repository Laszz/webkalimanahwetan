<?php

// Migrasi tabel survey_jawabans - jawaban warga per pertanyaan survei

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Buat tabel survey_jawabans + relasi survei, pertanyaan, dan penjawab
    public function up(): void
    {
        Schema::create('survey_jawabans', function (Blueprint $table) {
            $table->id();
            // Survei yang dijawab; ikut terhapus jika survei dihapus
            $table->foreignId('survey_id')->constrained('surveys')->cascadeOnDelete();
            // Pertanyaan yang dijawab; ikut terhapus jika pertanyaan dihapus
            $table->foreignId('pertanyaan_id')->constrained('survey_pertanyaans')->cascadeOnDelete();
            // Warga penjawab; ikut terhapus jika user dihapus
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // Isi jawaban (angka skala disimpan sebagai teks)
            $table->text('jawaban');
            // Periode pengisian agar survei berulang bisa dijawab tiap periode
            $table->unsignedSmallInteger('tahun');
            $table->unsignedTinyInteger('bulan');
            $table->timestamps();

            // Satu user satu jawaban per pertanyaan per periode.
            $table->unique([
                'survey_id',
                'pertanyaan_id',
                'user_id',
                'tahun',
                'bulan',
            ], 'survey_jawabans_unik');
        });
    }

    // Kembalikan: hapus tabel survey_jawabans
    public function down(): void
    {
        Schema::dropIfExists('survey_jawabans');
    }
};
