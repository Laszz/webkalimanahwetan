<?php

// Migrasi penambah kolom kode pos ke tabel profil_desas untuk kop surat otomatis

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Tambah kolom kode pos setelah alamat
    public function up(): void
    {
        Schema::table('profil_desas', function (Blueprint $table) {
            $table->string('kode_pos', 10)->nullable()->after('alamat');
        });
    }

    // Kembalikan: hapus kolom kode pos
    public function down(): void
    {
        Schema::table('profil_desas', function (Blueprint $table) {
            $table->dropColumn('kode_pos');
        });
    }
};
