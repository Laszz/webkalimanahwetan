<?php

// Validasi ubah galeri oleh admin (foto lama boleh dipertahankan)

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGaleriRequest extends FormRequest
{
    // Hanya admin yang boleh kelola galeri (route juga dikunci admin)
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    // Aturan validasi; gambar opsional karena boleh pakai foto lama
    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'published_at' => ['nullable', 'date'],
        ];
    }
}
