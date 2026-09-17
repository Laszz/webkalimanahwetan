<?php

// Validasi agenda baru oleh admin

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreAgendaRequest extends FormRequest
{
    // Hanya admin yang boleh kelola agenda (route juga dikunci admin)
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    // Aturan validasi kolom agenda
    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'tempat' => ['required', 'string', 'max:255'],
            'mulai' => ['required', 'date'],
            // Selesai boleh kosong dan tidak boleh mendahului mulai
            'selesai' => ['nullable', 'date', 'after_or_equal:mulai'],
        ];
    }
}
