<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('upload_syarat_layanans', function (Blueprint $table) {
            $table->id();
            // Pengajuan pemilik berkas; ikut terhapus jika pengajuan dihapus
            $table->foreignId('pengajuan_layanan_id')->constrained('pengajuan_layanans')->cascadeOnDelete();
            // Syarat yang dipenuhi berkas ini; ikut terhapus jika syarat dihapus
            $table->foreignId('syarat_layanan_id')->constrained('syarat_layanans')->cascadeOnDelete();
            // Path file di storage (diisi jika syarat bertipe file)
            $table->string('file_path')->nullable();
            // Isian tulisan warga (diisi jika syarat bertipe text)
            $table->text('isi')->nullable();
            $table->timestamps();

            // Satu syarat hanya satu record per pengajuan
            $table->unique(['pengajuan_layanan_id', 'syarat_layanan_id'],
                            'upload_syarat_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('upload_syarat_layanans');
    }
};
