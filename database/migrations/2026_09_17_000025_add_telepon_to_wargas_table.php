<?php

// Migrasi penambah kolom telepon ke tabel wargas untuk kontak warga

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Tambah kolom telepon setelah pekerjaan
    public function up(): void
    {
        Schema::table('wargas', function (Blueprint $table) {
            $table->string('telepon', 20)->nullable()->after('pekerjaan');
        });
    }

    // Kembalikan: hapus kolom telepon
    public function down(): void
    {
        Schema::table('wargas', function (Blueprint $table) {
            $table->dropColumn('telepon');
        });
    }
};
