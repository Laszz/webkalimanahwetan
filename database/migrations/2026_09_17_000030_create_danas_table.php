<?php

// Migrasi tabel danas - pagu per sumber dana per tahun

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Buat tabel danas + unik per tahun dan sumber
    public function up(): void
    {
        Schema::create('danas', function (Blueprint $table) {
            $table->id();
            // Tahun anggaran, diindeks karena sering difilter
            $table->year('tahun')->index();
            // Asal dana, mis. Dana Desa (DD), ADD
            $table->string('sumber_dana');
            // Pagu total dalam rupiah
            $table->unsignedBigInteger('anggaran')->default(0);
            $table->timestamps();

            $table->unique(['tahun', 'sumber_dana']);
        });
    }

    // Kembalikan: hapus tabel danas
    public function down(): void
    {
        Schema::dropIfExists('danas');
    }
};
