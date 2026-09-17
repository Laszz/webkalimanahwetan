<?php

// Validasi ubah template hasil oleh admin (file boleh dipertahankan)

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTemplateRequest extends FormRequest
{
    // Hanya admin yang boleh kelola template (route juga dikunci admin)
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    // Aturan validasi; file opsional karena boleh pakai template lama
    public function rules(): array
    {
        return [
            'file' => ['nullable', 'file', 'mimes:doc,docx', 'max:5120'],
        ];
    }
}
