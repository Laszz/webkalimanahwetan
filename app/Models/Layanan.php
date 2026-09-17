<?php

// Model Layanan - jenis surat yang bisa diajukan warga

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Layanan extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi massal
    protected $fillable = [
        'nama', 
        'deskripsi', 
        'estimasi_hari', 
        'aktif'
    ];

    // Konversi tipe otomatis saat dibaca
    protected function casts(): array
    {
        return ['estimasi_hari' => 'integer', 'aktif' => 'boolean'];
    }

    // Syarat berkas tiap layanan
    public function syaratLayanan(): HasMany
    {
        return $this->hasMany(SyaratLayanan::class);
    }

    // Pengajuan masuk untuk layanan ini
    public function pengajuanLayanan(): HasMany
    {
        return $this->hasMany(PengajuanLayanan::class);
    }

    // Template dokumen hasil layanan ini
    public function templateHasilLayanan(): HasOne
    {
        return $this->hasOne(TemplateHasilLayanan::class);
    }

    // Hanya layanan yang sedang dibuka
    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('aktif', true);
    }
}
