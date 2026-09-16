<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            // ID UUID sesuai konvensi notifikasi Laravel
            $table->uuid('id')->primary();
            // Class notifikasi pengirim
            $table->string('type');
            // Polymorphic ke penerima (users atau model lain)
            $table->morphs('notifiable');
            // Isi notifikasi dalam JSON
            $table->text('data');
            // Waktu dibaca; kosong = belum dibaca
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
