<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aduans', function (Blueprint $table) {
            $table->id();
            // Pelapor wajib akun warga yang login; ikut terhapus jika user dihapus
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('judul');
            $table->text('isi');
            // Foto bukti aduan dari warga (path file di storage)
            $table->string('gambar')->nullable();
            // Alur status: menunggu -> diproses -> selesai
            $table->enum('status', ['menunggu', 'diproses', 'selesai'])->default('menunggu')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aduans');
    }
};
