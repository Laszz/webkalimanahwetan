<?php

// Migrasi penambah kolom nomor surat dan file hasil ke tabel pengajuan_layanans untuk unduhan warga

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Tambah nomor surat (diisi admin saat selesai) + path dokumen hasil generate
    public function up(): void
    {
        Schema::table('pengajuan_layanans', function (Blueprint $table) {
            $table->string('nomor_surat')->nullable()->after('catatan');
            $table->string('file_hasil')->nullable()->after('nomor_surat');
        });
    }

    // Kembalikan: hapus kedua kolom
    public function down(): void
    {
        Schema::table('pengajuan_layanans', function (Blueprint $table) {
            $table->dropColumn(['nomor_surat', 'file_hasil']);
        });
    }
};
