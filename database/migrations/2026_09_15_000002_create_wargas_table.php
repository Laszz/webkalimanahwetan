<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wargas', function (Blueprint $table) {
            $table->id();
            // Pemilik akun; unik agar 1 akun hanya punya 1 biodata warga.
            // Ikut terhapus jika user dihapus
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            // NIK 16 digit, unik satu warga satu NIK
            $table->string('nik', 16)->unique();
            // Nomor Kartu Keluarga
            $table->string('no_kk', 16);
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            // L = laki-laki, P = perempuan
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->text('alamat');
            $table->string('rt', 3);
            $table->string('rw', 3);
            $table->string('agama', 30);
            $table->string('status_kawin', 30);
            $table->string('pekerjaan')->nullable();
            $table->timestamps();
            // Hapus lunak agar riwayat warga tidak hilang permanen
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wargas');
    }
};
