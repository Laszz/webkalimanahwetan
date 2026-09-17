<?php

// Validasi tanggapan aduan baru oleh admin

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreTanggapanRequest extends FormRequest
{
    // Hanya admin yang boleh menanggapi (route juga dikunci admin)
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    // Aturan validasi isi tanggapan
    public function rules(): array
    {
        return [
            'isi' => ['required', 'string'],
        ];
    }
}
