<?php

// Model PenerimaBantuan - warga penerima tiap jenis bantuan per periode

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenerimaBantuan extends Model
{
    use HasFactory;

    // Nama tabel eksplisit (kata Indonesia tidak dikenali pluralizer Inggris)
    protected $table = 'penerima_bantuans';

    // Kolom yang boleh diisi massal
    protected $fillable = [
        'jenis_bantuan_id', 
        'warga_id', 
        'keterangan', 
        'nominal', 
        'tahun', 
        'bulan'
    ];

    // Konversi tipe otomatis saat dibaca
    protected function casts(): array
    {
        return ['nominal' => 'integer', 'tahun' => 'integer', 'bulan' => 'integer'];
    }

    // Jenis bantuan yang diterima
    public function jenisBantuan(): BelongsTo
    {
        return $this->belongsTo(JenisBantuan::class);
    }

    // Warga penerima (diambil dari data warga terdaftar)
    public function warga(): BelongsTo
    {
        return $this->belongsTo(Warga::class);
    }
}
