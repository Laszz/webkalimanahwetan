<?php

// Migrasi penambah kolom foto ke tabel wargas untuk foto profil

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Tambah kolom foto setelah pekerjaan
    public function up(): void
    {
        Schema::table('wargas', function (Blueprint $table) {
            // Path foto profil di storage
            $table->string('foto')->nullable()->after('pekerjaan');
        });
    }

    // Kembalikan: hapus kolom foto
    public function down(): void
    {
        Schema::table('wargas', function (Blueprint $table) {
            $table->dropColumn('foto');
        });
    }
};
