<?php

// Validasi foto galeri baru oleh admin

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreGaleriRequest extends FormRequest
{
    // Hanya admin yang boleh kelola galeri (route juga dikunci admin)
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    // Aturan validasi kolom galeri
    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            // Foto wajib saat tambah baru, maksimal 2MB
            'gambar' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            // Kosong = simpan sebagai draf
            'published_at' => ['nullable', 'date'],
        ];
    }
}
