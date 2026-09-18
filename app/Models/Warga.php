<?php

// Model Warga - biodata kependudukan milik satu akun user

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warga extends Model
{
    use HasFactory, SoftDeletes;

    // Kolom yang boleh diisi massal (user_id dikecualikan: relasi akun dikontrol via logic aplikasi)
    // nik_hash ikut fillable karena selalu ditimpa hasil hash controller, bukan input user
    protected $fillable = [
        'nik',
        'nik_hash',
        'no_kk',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'rt',
        'rw',
        'agama',
        'status_kawin',
        'pekerjaan',
        'telepon',
        'foto',
    ];

    // Konversi tipe otomatis; nik dan no_kk terenkripsi di database tapi terbaca asli di aplikasi
    protected function casts(): array
    {
        return [
            'nik' => 'encrypted',
            'no_kk' => 'encrypted',
            'tanggal_lahir' => 'date',
        ];
    }

    // Akun pemilik biodata ini
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
