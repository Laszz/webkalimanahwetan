<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perangkat_desas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            // Jabatan, mis. Kepala Desa, Sekretaris Desa, Kaur Keuangan
            $table->string('jabatan');
            // Path foto profil di storage
            $table->string('foto')->nullable();
            $table->string('telepon', 20)->nullable();
            // Nomor urut tampil di halaman perangkat
            $table->unsignedSmallInteger('urutan')->default(0);
            // Nonaktif = tidak tampil di halaman perangkat
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perangkat_desas');
    }
};
