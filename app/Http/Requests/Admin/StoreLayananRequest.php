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

    // Aturan validasi kolom layanan + daftar syarat bawaannya
    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'estimasi_hari' => ['nullable', 'integer', 'min:1'],
            // Syarat awal boleh kosong; tiap item: nama, tipe file/text, wajib opsional
            'syarat' => ['nullable', 'array'],
            'syarat.*.nama' => ['required_with:syarat', 'string', 'max:255'],
            'syarat.*.tipe' => ['required_with:syarat', 'in:file,text'],
            'syarat.*.wajib' => ['nullable', 'boolean'],
        ];
    }
}
