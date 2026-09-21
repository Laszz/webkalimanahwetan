<?php

// Validasi layanan baru oleh admin

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreLayananRequest extends FormRequest
{
    // Hanya admin yang boleh kelola layanan (route juga dikunci admin)
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    // Aturan validasi kolom layanan (syarat diatur di halaman syarat)
    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'estimasi_hari' => ['nullable', 'integer', 'min:1'],
        ];
    }
}
