<?php

// Model Berita - kabar dan pengumuman desa

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Berita extends Model
{
    use HasFactory, SoftDeletes;

    // Kolom yang boleh diisi massal (user_id dikecualikan: penulis diisi dari user login via relasi)
    protected $fillable = [
        'judul',
        'slug',
        'ringkasan',
        'konten',
        'gambar',
        'published_at',
    ];

    // Konversi tipe otomatis saat dibaca
    protected function casts(): array
    {
        return ['published_at' => 'datetime'];
    }

    // Admin penulis berita
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Hanya yang sudah terbit, terbaru dulu
    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at');
    }
}
