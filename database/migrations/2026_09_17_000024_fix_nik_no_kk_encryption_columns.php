<?php

// Migrasi perbaikan kolom NIK/KK terenkripsi: ciphertext butuh kolom besar + hash untuk uniqueness

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Perbesar kolom ciphertext, hapus unique tak berguna, tambah hash NIK
    public function up(): void
    {
        Schema::table('wargas', function (Blueprint $table) {
            // Unique di atas ciphertext acak tidak bisa cegah NIK ganda
            $table->dropUnique(['nik']);
            // Ciphertext Laravel jauh lebih dari 16 karakter
            $table->text('nik')->change();
            $table->text('no_kk')->change();
            // SHA-256 NIK asli untuk cek duplikat berdasarkan nilai plaintext
            $table->string('nik_hash', 64)->unique()->after('nik');
        });
    }

    // Kembalikan: hapus hash, kecilkan lagi kolomnya, kembalikan unique
    public function down(): void
    {
        Schema::table('wargas', function (Blueprint $table) {
            $table->dropUnique(['nik_hash']);
            $table->dropColumn('nik_hash');
            $table->string('nik', 16)->change();
            $table->string('no_kk', 18)->change();
            $table->unique('nik');
        });
    }
};
