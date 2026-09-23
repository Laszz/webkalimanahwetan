<?php

// Model Dana - pagu per sumber dana per tahun

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dana extends Model
{
    use HasFactory;

    // Daftar sumber dana baku desa (satu sumber kebenaran untuk form + validasi)
    public const SUMBER = [
        'Dana Desa (DD)',
        'Alokasi Dana Desa (ADD)',
        'Pendapatan Asli Desa (PADes)',
        'Bagi Hasil Pajak dan Retribusi Daerah',
        'Bantuan Keuangan Provinsi',
        'Bantuan Keuangan Kabupaten/Kota',
        'Pendapatan Lain-Lain',
        'Swadaya Masyarakat',
    ];

    // Kolom yang boleh diisi massal
    protected $fillable = ['tahun', 'sumber_dana', 'anggaran'];

    // Konversi tipe otomatis saat dibaca
    protected function casts(): array
    {
        return ['tahun' => 'integer', 'anggaran' => 'integer'];
    }

    // Belanja yang memakai dana ini
    public function belanjas(): HasMany
    {
        return $this->hasMany(Belanja::class);
    }

    // Sisa yang masih bisa dipakai (butuh withSum belanjas sebagai terpakai)
    public function sisa(): int
    {
        return max(0, $this->anggaran - (int) ($this->terpakai ?? $this->belanjas()->sum('nominal')));
    }
}
