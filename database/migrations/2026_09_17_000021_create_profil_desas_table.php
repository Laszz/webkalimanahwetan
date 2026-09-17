<?php

// Migrasi tabel profil_desas - profil, visi misi, dan sejarah desa (satu baris aktif)

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Buat tabel profil_desas
    public function up(): void
    {
        Schema::create('profil_desas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_desa');
            $table->text('visi');
            $table->text('misi');
            $table->longText('sejarah')->nullable();
            $table->text('alamat')->nullable();
            $table->string('telepon', 20)->nullable();
            $table->string('email')->nullable();
            // Path logo desa di storage
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    // Kembalikan: hapus tabel profil_desas
    public function down(): void
    {
        Schema::dropIfExists('profil_desas');
    }
};
