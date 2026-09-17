<?php

// Model SyaratLayanan - daftar berkas syarat tiap jenis layanan

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SyaratLayanan extends Model
{
    use HasFactory;

    // Nama tabel eksplisit (kata Indonesia tidak dikenali pluralizer Inggris)
    protected $table = 'syarat_layanans';

    // Kolom yang boleh diisi massal
    protected $fillable = [
        'layanan_id', 
        'nama', 
        'tipe', 
        'wajib'
    ];

    // Konversi tipe otomatis saat dibaca
    protected function casts(): array
    {
        return ['wajib' => 'boolean'];
    }

    // Layanan pemilik syarat
    public function layanan(): BelongsTo
    {
        return $this->belongsTo(Layanan::class);
    }

    // Berkas terunggah untuk syarat ini
    public function uploadSyaratLayanan(): HasMany
    {
        return $this->hasMany(UploadSyaratLayanan::class);
    }
}
