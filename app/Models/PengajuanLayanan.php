<?php

// Model PengajuanLayanan - permohonan surat oleh warga

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PengajuanLayanan extends Model
{
    use HasFactory;

    // Nama tabel eksplisit (kata Indonesia tidak dikenali pluralizer Inggris)
    protected $table = 'pengajuan_layanans';

    // Kolom yang boleh diisi massal (user_id diisi otomatis via relasi auth)
    protected $fillable = [
        'layanan_id',
        'keperluan',
        'status',
        'catatan',
        'nomor_surat',
        'file_hasil'
    ];

    // Warga pemohon
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Layanan yang diajukan
    public function layanan(): BelongsTo
    {
        return $this->belongsTo(Layanan::class);
    }

    // Berkas syarat yang diunggah pemohon
    public function uploadSyaratLayanan(): HasMany
    {
        return $this->hasMany(UploadSyaratLayanan::class);
    }

    // Saring berdasarkan status (menunggu/diproses/selesai/ditolak)
    public function scopeByStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }
}
