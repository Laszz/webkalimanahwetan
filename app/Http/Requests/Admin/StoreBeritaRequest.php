<?php

// Validasi berita baru oleh admin

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreBeritaRequest extends FormRequest
{
    // Hanya admin yang boleh tulis berita (route juga dikunci admin)
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    // Aturan validasi kolom berita
    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:255'],
            'ringkasan' => ['nullable', 'string'],
            'konten' => ['required', 'string'],
            // Gambar sampul opsional, maksimal 2MB
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            // Kosong = simpan sebagai draf
            'published_at' => ['nullable', 'date'],
        ];
    }
}
