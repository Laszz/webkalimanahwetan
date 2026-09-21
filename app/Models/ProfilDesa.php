<?php

// Model ProfilDesa - profil, visi misi, dan sejarah desa

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilDesa extends Model
{
    use HasFactory;

    // Nama tabel eksplisit (kata Indonesia tidak dikenali pluralizer Inggris)
    protected $table = 'profil_desas';

    // Kolom yang boleh diisi massal
    protected $fillable = [
        'nama_desa', 'visi', 'misi', 'sejarah',
        'alamat', 'kode_pos', 'telepon', 'email', 'logo',
    ];
}
