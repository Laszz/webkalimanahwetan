<?php

// Validasi perangkat desa baru oleh admin

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePerangkatDesaRequest extends FormRequest
{
    // Hanya admin yang boleh kelola perangkat (route juga dikunci admin)
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    // Aturan validasi kolom perangkat
    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'jabatan' => ['required', 'string', 'max:255'],
            // Foto profil opsional, maksimal 2MB
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'telepon' => ['nullable', 'string', 'max:20'],
            'urutan' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
