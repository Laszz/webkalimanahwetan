<?php

// Validasi pertanyaan survei baru oleh admin

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePertanyaanRequest extends FormRequest
{
    // Hanya admin yang boleh kelola pertanyaan (route juga dikunci admin)
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    // Aturan validasi kolom pertanyaan
    public function rules(): array
    {
        return [
            'pertanyaan' => ['required', 'string'],
            'tipe' => ['required', 'in:skala,text'],
            'urutan' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
