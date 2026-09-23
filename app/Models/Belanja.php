<?php

// Model Belanja - pakai dana untuk kegiatan per bidang

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Belanja extends Model
{
    use HasFactory;

    // Lima bidang baku desa (satu sumber kebenaran untuk form + validasi)
    public const BIDANG = [
        'Penyelenggaraan Pemerintahan',
        'Pelaksanaan Pembangunan',
        'Pembinaan Kemasyarakatan',
        'Pemberdayaan Masyarakat',
        'Penanggulangan Bencana',
    ];

    // Kolom yang boleh diisi massal
    protected $fillable = ['dana_id', 'bidang', 'uraian', 'nominal'];

    // Konversi tipe otomatis saat dibaca
    protected function casts(): array
    {
        return ['nominal' => 'integer'];
    }

    // Dana yang dipakai belanja ini
    public function dana(): BelongsTo
    {
        return $this->belongsTo(Dana::class);
    }
}
