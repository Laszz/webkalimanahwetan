<?php

// Model Apbdes - anggaran pendapatan dan belanja desa per bidang per tahun

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apbdes extends Model
{
    use HasFactory;

    // Nama tabel eksplisit (kata Indonesia tidak dikenali pluralizer Inggris)
    protected $table = 'apbdes';

    // Kolom yang boleh diisi massal
    protected $fillable = [
        'tahun', 
        'bidang', 
        'uraian', 
        'sumber_dana', 
        'anggaran', 
        'realisasi'
    ];

    // Konversi tipe otomatis saat dibaca
    protected function casts(): array
    {
        return [
            'tahun' => 'integer',
            'anggaran' => 'integer',
            'realisasi' => 'integer',
        ];
    }
}
