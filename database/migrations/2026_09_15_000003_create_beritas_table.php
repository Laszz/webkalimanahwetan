<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            // Penulis (admin); ikut terhapus jika user dihapus
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('judul');
            // Slug unik untuk URL ramah mesin pencari
            $table->string('slug')->unique();
            // Ringkasan tampil di daftar berita
            $table->text('ringkasan')->nullable();
            $table->longText('konten');
            // Path gambar sampul di storage
            $table->string('gambar')->nullable();
            // Waktu terbit; kosong = masih draf
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamps();
            // Hapus lunak agar arsip berita tidak hilang permanen
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};
