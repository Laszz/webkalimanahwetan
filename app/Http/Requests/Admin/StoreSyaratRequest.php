<?php

// Validasi syarat layanan baru oleh admin

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreSyaratRequest extends FormRequest
{
    // Hanya admin yang boleh kelola syarat (route juga dikunci admin)
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    // Aturan validasi kolom syarat
    public function rules(): array
    {
        return [
            'layanan_id' => ['required', 'exists:layanans,id'],
            'nama' => ['required', 'string', 'max:255'],
            'tipe' => ['required', 'in:file,text'],
        ];
    }
}
