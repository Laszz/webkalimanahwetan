<?php

// Validasi isian survei warga; aturan dibangun dinamis dari pertanyaan survei

namespace App\Http\Requests\Warga;

use Illuminate\Foundation\Http\FormRequest;

class IsiSurveyRequest extends FormRequest
{
    // Hanya user login yang boleh mengisi (route juga dikunci auth)
    public function authorize(): bool
    {
        return auth()->check();
    }

    // Aturan validasi: satu aturan per pertanyaan (skala 1-5 atau teks)
    public function rules(): array
    {
        $rules = [];
        $survey = $this->route('survey');

        foreach ($survey->pertanyaans as $tanya) {
            $wajib = $tanya->wajib ? 'required' : 'nullable';
            $rules["jawaban.{$tanya->id}"] = $tanya->tipe === 'skala'
                ? [$wajib, 'integer', 'min:1', 'max:5']
                : [$wajib, 'string', 'max:1000'];
        }

        return $rules;
    }
}
