<?php

// Validasi survei baru oleh admin

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreSurveyRequest extends FormRequest
{
    // Hanya admin yang boleh kelola survei (route juga dikunci admin)
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    // Aturan validasi: pertanyaan + tipe dulu, judul dibuat otomatis
    public function rules(): array
    {
        return [
            // Pertanyaan pertama langsung di form survei
            'pertanyaan' => ['required', 'string'],
            'tipe' => ['required', 'in:skala,text'],
            'mulai' => ['nullable', 'date'],
            // Selesai boleh kosong dan tidak boleh mendahului mulai
            'selesai' => ['nullable', 'date', 'after_or_equal:mulai'],
        ];
    }
}
