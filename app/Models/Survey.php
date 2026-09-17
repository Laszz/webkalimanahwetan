<?php

// Model Survey - daftar survei kepuasan pegawai/layanan desa

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Survey extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi massal
    protected $fillable = ['judul', 'deskripsi', 'aktif', 'mulai', 'selesai'];

    // Konversi tipe otomatis saat dibaca
    protected function casts(): array
    {
        return ['aktif' => 'boolean', 'mulai' => 'datetime', 'selesai' => 'datetime'];
    }

    // Butir pertanyaan milik survei ini
    public function pertanyaans(): HasMany
    {
        return $this->hasMany(SurveyPertanyaan::class);
    }

    // Jawaban masuk untuk survei ini
    public function jawabans(): HasMany
    {
        return $this->hasMany(SurveyJawaban::class);
    }

    // Hanya survei yang sedang dibuka
    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('aktif', true);
    }
}
