<?php

// Validasi pos APBDes baru oleh admin

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreApbdesRequest extends FormRequest
{
    // Hanya admin yang boleh kelola APBDes (route juga dikunci admin)
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    // Aturan validasi kolom APBDes
    public function rules(): array
    {
        return [
            'tahun' => ['required', 'integer', 'min:2000', 'max:2100'],
            'bidang' => ['required', 'string', 'max:255'],
            'uraian' => ['required', 'string', 'max:255'],
            'sumber_dana' => ['required', 'string', 'max:255'],
            // Rupiah tanpa titik/koma
            'anggaran' => ['required', 'integer', 'min:0'],
            'realisasi' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
