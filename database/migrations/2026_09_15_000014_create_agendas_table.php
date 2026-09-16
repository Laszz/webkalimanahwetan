<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('tempat');
            // Waktu mulai, diindeks karena sering diurutkan
            $table->dateTime('mulai')->index();
            // Waktu selesai; kosong untuk kegiatan tanpa batas pasti
            $table->dateTime('selesai')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};
