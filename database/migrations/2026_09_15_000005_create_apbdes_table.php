<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('apbdes', function (Blueprint $table) {
            $table->id();
            // Tahun anggaran, diindeks karena sering difilter
            $table->year('tahun')->index();
            // Bidang kegiatan, mis. penyelenggaraan pemerintahan, pembangunan
            $table->string('bidang');
            $table->string('uraian');
            // Asal dana alokasi bidang ini, mis. Dana Desa, ADD, PADes
            $table->string('sumber_dana');
            // Pagu anggaran dalam rupiah
            $table->unsignedBigInteger('anggaran')->default(0);
            // Serapan terealisasi dalam rupiah
            $table->unsignedBigInteger('realisasi')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apbdes');
    }
};
