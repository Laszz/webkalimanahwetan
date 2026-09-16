<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('syarat_layanans', function (Blueprint $table) {
            $table->id();
            // Layanan pemilik syarat; ikut terhapus jika layanan dihapus
            $table->foreignId('layanan_id')->constrained('layanans')->cascadeOnDelete();
            // Nama berkas syarat, mis. fotokopi KTP
            $table->string('nama');
            // Jenis isian syarat yg ditentukan admin: file (unggah berkas) atau text (isian tulisan)
            $table->enum('tipe', ['file', 'text'])->default('file');
            // Wajib = harus diunggah agar pengajuan bisa diproses
            $table->boolean('wajib')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('syarat_layanans');
    }
};
