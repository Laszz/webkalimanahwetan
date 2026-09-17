<?php

// Model Aduan - laporan warga kepada perangkat desa

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Aduan extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi massal (user_id diisi otomatis via relasi auth)
    protected $fillable = [
        'judul', 
        'isi', 
        'gambar', 
        'status'
    ];

    // Warga pelapor
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Balasan admin atas aduan ini
    public function tanggapanAduan(): HasMany
    {
        return $this->hasMany(TanggapanAduan::class);
    }

    // Saring berdasarkan status (menunggu/diproses/selesai)
    public function scopeByStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }
}
