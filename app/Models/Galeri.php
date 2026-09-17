<?php

// Model Galeri - dokumentasi foto kegiatan desa

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi massal
    protected $fillable = [
        'judul', 
        'deskripsi', 
        'gambar', 
        'published_at'
    ];

    // Konversi tipe otomatis saat dibaca
    protected function casts(): array
    {
        return ['published_at' => 'datetime'];
    }

    // Hanya yang sudah terbit, terbaru dulu
    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at');
    }
}
