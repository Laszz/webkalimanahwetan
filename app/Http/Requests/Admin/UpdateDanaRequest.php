<?php

// Validasi ubah dana oleh admin (pagu tidak boleh di bawah yang sudah terpakai)

namespace App\Http\Requests\Admin;

use App\Models\Dana;
use Illuminate\Validation\Rule;

class UpdateDanaRequest extends StoreDanaRequest
{
    // Aturan validasi + pagu minimal total terpakai
    public function rules(): array
    {
        return [
            'tahun' => ['required', 'integer', 'min:2000', 'max:2100'],
            'sumber_dana' => [
                'required',
                'string',
                Rule::in(Dana::SUMBER),
                // Abaikan baris sendiri saat cek duplikat
                Rule::unique('danas')->ignore($this->route('dana'))->where(fn ($query) => $query->where('tahun', $this->input('tahun'))),
            ],
            'anggaran' => [
                'required',
                'integer',
                'min:0',
                // Pagu tidak boleh di bawah total yang sudah dibelanjakan
                function ($atribut, $nilai, $gagal) {
                    $terpakai = $this->route('dana')->belanjas()->sum('nominal');
                    if ($nilai < $terpakai) {
                        $gagal('Anggaran tidak boleh di bawah total terpakai Rp' . number_format($terpakai, 0, ',', '.') . '.');
                    }
                },
            ],
        ];
    }
}
