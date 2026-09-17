<?php

// Model SurveyPertanyaan - butir pertanyaan tiap survei

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SurveyPertanyaan extends Model
{
    use HasFactory;

    // Nama tabel eksplisit (kata Indonesia tidak dikenali pluralizer Inggris)
    protected $table = 'survey_pertanyaans';

    // Kolom yang boleh diisi massal (survey_id diisi otomatis via relasi)
    protected $fillable = ['pertanyaan', 'tipe', 'wajib', 'urutan'];

    // Konversi tipe otomatis saat dibaca
    protected function casts(): array
    {
        return ['wajib' => 'boolean', 'urutan' => 'integer'];
    }

    // Survei pemilik pertanyaan
    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }

    // Jawaban masuk untuk pertanyaan ini
    public function jawabans(): HasMany
    {
        return $this->hasMany(SurveyJawaban::class, 'pertanyaan_id');
    }
}
