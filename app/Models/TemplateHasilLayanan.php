<?php

// Model TemplateHasilLayanan - file template Word resmi per jenis layanan

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TemplateHasilLayanan extends Model
{
    use HasFactory;

    // Nama tabel eksplisit (kata Indonesia tidak dikenali pluralizer Inggris)
    protected $table = 'template_hasil_layanans';

    // Kolom yang boleh diisi massal
    protected $fillable = ['layanan_id', 'file_path', 'aktif'];

    // Konversi tipe otomatis saat dibaca
    protected function casts(): array
    {
        return ['aktif' => 'boolean'];
    }

    // Layanan pemilik template
    public function layanan(): BelongsTo
    {
        return $this->belongsTo(Layanan::class);
    }
}
