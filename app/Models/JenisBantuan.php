<?php

// Model JenisBantuan - master jenis bantuan sosial desa

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisBantuan extends Model
{
    use HasFactory;

    // Nama tabel eksplisit (kata Indonesia tidak dikenali pluralizer Inggris)
    protected $table = 'jenis_bantuans';

    // Kolom yang boleh diisi massal
    protected $fillable = [
        'nama', 
        'deskripsi'
    ];

    // Warga penerima jenis bantuan ini
    public function penerimaBantuan(): HasMany
    {
        return $this->hasMany(PenerimaBantuan::class);
    }
}
