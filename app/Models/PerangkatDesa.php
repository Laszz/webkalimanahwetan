<?php

// Model PerangkatDesa - susunan perangkat dan pamong desa

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerangkatDesa extends Model
{
    use HasFactory;

    // Nama tabel eksplisit (kata Indonesia tidak dikenali pluralizer Inggris)
    protected $table = 'perangkat_desas';

    // Kolom yang boleh diisi massal
    protected $fillable = [
        'nama', 
        'jabatan', 
        'foto', 
        'telepon', 
        'urutan', 
        'aktif'
    ];

    // Konversi tipe otomatis saat dibaca
    protected function casts(): array
    {
        return ['urutan' => 'integer', 'aktif' => 'boolean'];
    }

    // Hanya yang aktif, berurutan sesuai nomor tampil
    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('aktif', true)->orderBy('urutan');
    }
}
