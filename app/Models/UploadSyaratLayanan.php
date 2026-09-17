<?php

// Model UploadSyaratLayanan - berkas atau isian syarat per pengajuan

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UploadSyaratLayanan extends Model
{
    use HasFactory;

    // Nama tabel eksplisit (kata Indonesia tidak dikenali pluralizer Inggris)
    protected $table = 'upload_syarat_layanans';

    // Kolom yang boleh diisi massal
    protected $fillable = [
        'pengajuan_layanan_id', 
        'syarat_layanan_id', 
        'file_path', 
        'isi'
    ];

    // Pengajuan pemilik berkas
    public function pengajuanLayanan(): BelongsTo
    {
        return $this->belongsTo(PengajuanLayanan::class);
    }

    // Syarat yang dipenuhi berkas ini
    public function syaratLayanan(): BelongsTo
    {
        return $this->belongsTo(SyaratLayanan::class);
    }
}
