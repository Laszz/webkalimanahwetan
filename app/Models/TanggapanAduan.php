<?php

// Model TanggapanAduan - balasan admin atas laporan warga

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TanggapanAduan extends Model
{
    use HasFactory;

    // Nama tabel eksplisit (kata Indonesia tidak dikenali pluralizer Inggris)
    protected $table = 'tanggapan_aduans';

    // Kolom yang boleh diisi massal (user_id diisi otomatis dari admin login)
    protected $fillable = ['aduan_id', 'user_id', 'isi'];

    // Aduan yang ditanggapi
    public function aduan(): BelongsTo
    {
        return $this->belongsTo(Aduan::class);
    }

    // Admin penanggap
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
