<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penerima_bantuans', function (Blueprint $table) {
            $table->id();
            // Jenis bantuan yang diterima; ikut terhapus jika jenis dihapus
            $table->foreignId('jenis_bantuan_id')->constrained('jenis_bantuans')->cascadeOnDelete();
            // Warga penerima diambil dari data warga yg sudah ada (bukan ketik manual);
            // ikut terhapus jika data warga dihapus
            $table->foreignId('warga_id')->constrained('wargas')->cascadeOnDelete();
            // Keterangan tambahan, mis. periode penyaluran
            $table->text('keterangan')->nullable();
            // Jumlah uang bantuan dalam rupiah per warga
            $table->unsignedBigInteger('nominal')->default(0);
            // Tahun/periode penerimaan, diindeks karena sering difilter
            $table->year('tahun')->index();
            // Bulan penerimaan 1-12; kosong untuk bantuan tahunan
            $table->unsignedTinyInteger('bulan')->nullable();
            $table->timestamps();

            // Satu warga hanya sekali per jenis bantuan per tahun
            $table->unique(['jenis_bantuan_id', 'warga_id', 'tahun', 'bulan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penerima_bantuans');
    }
};
