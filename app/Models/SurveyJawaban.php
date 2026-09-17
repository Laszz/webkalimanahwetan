<?php

// Model SurveyJawaban - jawaban warga per pertanyaan survei per periode

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SurveyJawaban extends Model
{
    use HasFactory;

    // Nama tabel eksplisit (kata Indonesia tidak dikenali pluralizer Inggris)
    protected $table = 'survey_jawabans';

    // Kolom yang boleh diisi massal (user_id diisi otomatis dari user login)
    protected $fillable = ['survey_id', 'pertanyaan_id', 'jawaban', 'tahun', 'bulan'];

    // Konversi tipe otomatis saat dibaca
    protected function casts(): array
    {
        return ['tahun' => 'integer', 'bulan' => 'integer'];
    }

    // Survei yang dijawab
    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }

    // Pertanyaan yang dijawab
    public function pertanyaan(): BelongsTo
    {
        return $this->belongsTo(SurveyPertanyaan::class, 'pertanyaan_id');
    }

    // Warga penjawab
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
