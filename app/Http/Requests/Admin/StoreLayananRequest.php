<?php

// Validasi layanan baru oleh admin

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLayananRequest extends FormRequest
{
    // Hanya admin yang boleh kelola layanan (route juga dikunci admin)
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    // Daftar kategori baku layanan administrasi desa
    public static function kategoris(): array
    {
        return ['Administrasi Penduduk', 'Administrasi Umum', 'Administrasi Hukum Dan Tanah'];
    }

    // Aturan validasi kolom layanan (syarat diatur di halaman syarat)
    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', Rule::in(self::kategoris())],
            'deskripsi' => ['nullable', 'string'],
            'estimasi_hari' => ['nullable', 'integer', 'min:1'],
        ];
    }
}
