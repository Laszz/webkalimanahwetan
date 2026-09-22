<?php

// Migrasi penambah kolom kategori ke tabel layanans untuk pengelompokan jenis surat

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Tambah kolom kategori setelah nama
    public function up(): void
    {
        Schema::table('layanans', function (Blueprint $table) {
            $table->string('kategori')->nullable()->after('nama');
        });
    }

    // Kembalikan: hapus kolom kategori
    public function down(): void
    {
        Schema::table('layanans', function (Blueprint $table) {
            $table->dropColumn('kategori');
        });
    }
};
