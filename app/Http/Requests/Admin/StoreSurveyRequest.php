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

    // Aturan validasi kolom survei
    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'mulai' => ['nullable', 'date'],
            // Selesai boleh kosong dan tidak boleh mendahului mulai
            'selesai' => ['nullable', 'date', 'after_or_equal:mulai'],
        ];
    }
}
