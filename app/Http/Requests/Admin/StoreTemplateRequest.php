<?php

// Validasi template hasil baru oleh admin

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreTemplateRequest extends FormRequest
{
    // Hanya admin yang boleh kelola template (route juga dikunci admin)
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    // Aturan validasi: satu layanan satu template + file Word
    public function rules(): array
    {
        return [
            // Layanan belum punya template
            'layanan_id' => ['required', 'exists:layanans,id', 'unique:template_hasil_layanans,layanan_id'],
            // File Word resmi dari pemdes, maksimal 5MB
            'file' => ['required', 'file', 'mimes:doc,docx', 'max:5120'],
        ];
    }
}
