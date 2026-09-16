<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Peran pengguna untuk membedakan akses admin dan warga
            $table->enum('role', ['admin', 'warga'])->default('warga')->after('password');
            // Status verifikasi akun warga baru oleh admin
            $table->enum('status', ['menunggu', 'ditolak', 'disetujui'])->default('menunggu')->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'status']);
        });
    }
};
