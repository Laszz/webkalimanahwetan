<?php

// Validasi dana baru oleh admin (satu sumber satu pagu per tahun)

namespace App\Http\Requests\Admin;

use App\Models\Dana;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDanaRequest extends FormRequest
{
    // Hanya admin yang boleh kelola dana (route juga dikunci admin)
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    // Aturan validasi kolom dana
    public function rules(): array
    {
        return [
            'tahun' => ['required', 'integer', 'min:2000', 'max:2100'],
            'sumber_dana' => [
                'required',
                'string',
                Rule::in(Dana::SUMBER),
                // Satu sumber satu pagu per tahun
                Rule::unique('danas')->where(fn ($query) => $query->where('tahun', $this->input('tahun'))),
            ],
            // Rupiah tanpa titik/koma
            'anggaran' => ['required', 'integer', 'min:0'],
        ];
    }

    // Pesan Indonesia
    public function messages(): array
    {
        return [
            'sumber_dana.unique' => 'Sumber dana ini sudah punya pagu di tahun tersebut.',
        ];
    }
}
