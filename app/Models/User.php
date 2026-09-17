<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'status'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Biodata warga milik akun ini (satu akun satu warga)
    public function warga(): HasOne
    {
        return $this->hasOne(Warga::class);
    }

    // Aduan yang dilaporkan akun ini
    public function aduans(): HasMany
    {
        return $this->hasMany(Aduan::class);
    }

    // Pengajuan surat oleh akun ini
    public function pengajuanLayanan(): HasMany
    {
        return $this->hasMany(PengajuanLayanan::class);
    }

    // Berita yang ditulis akun ini
    public function beritas(): HasMany
    {
        return $this->hasMany(Berita::class);
    }

    // Jawaban survei oleh akun ini
    public function surveyJawabans(): HasMany
    {
        return $this->hasMany(SurveyJawaban::class);
    }

    // Cek peran untuk otorisasi akses
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Cek akun warga yang sudah disetujui
    public function isWargaAktif(): bool
    {
        return $this->role === 'warga' && $this->status === 'disetujui';
    }
}
