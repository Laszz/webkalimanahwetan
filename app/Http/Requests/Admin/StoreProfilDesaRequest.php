<?php

// Validasi profil desa oleh admin

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfilDesaRequest extends FormRequest
{
    // Hanya admin yang boleh kelola profil (route juga dikunci admin)
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    // Aturan validasi kolom profil
    public function rules(): array
    {
        return [
            'nama_desa' => ['required', 'string', 'max:255'],
            'visi' => ['required', 'string'],
            'misi' => ['required', 'string'],
            'sejarah' => ['nullable', 'string'],
            'alamat' => ['nullable', 'string'],
            'telepon' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            // Logo opsional, maksimal 2MB
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }
}
