<?php

// Validasi form aduan baru oleh warga

namespace App\Http\Requests\Warga;

use Illuminate\Foundation\Http\FormRequest;

class StoreAduanRequest extends FormRequest
{
    // Hanya user login yang boleh melapor (route juga dikunci auth)
    public function authorize(): bool
    {
        return auth()->check();
    }

    // Aturan validasi kolom aduan
    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:255'],
            'isi' => ['required', 'string'],
            // Foto bukti opsional, maksimal 2MB
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }
}
