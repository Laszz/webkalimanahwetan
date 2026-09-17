<?php

// Model Agenda - jadwal kegiatan desa

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi massal
    protected $fillable = [
        'judul', 
        'deskripsi', 
        'tempat', 
        'mulai', 
        'selesai'
    ];

    // Konversi tipe otomatis saat dibaca
    protected function casts(): array
    {
        return ['mulai' => 'datetime', 'selesai' => 'datetime'];
    }

    // Hanya agenda yang belum lewat, terdekat dulu
    public function scopeMendatang(Builder $query): Builder
    {
        return $query->where('mulai', '>=', now())->orderBy('mulai');
    }
}
