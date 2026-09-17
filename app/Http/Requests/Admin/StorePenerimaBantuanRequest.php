<?php

// Validasi penerima bantuan baru; warga dipilih dari data terdaftar (bukan ketik manual)

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePenerimaBantuanRequest extends FormRequest
{
    // Hanya admin yang boleh kelola penerima (route juga dikunci admin)
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    // Aturan validasi kolom penerima
    public function rules(): array
    {
        return [
            'jenis_bantuan_id' => ['required', 'exists:jenis_bantuans,id'],
            // Warga terdaftar; kombinasi jenis + warga + tahun harus unik
            'warga_id' => [
                'required',
                'exists:wargas,id',
                Rule::unique('penerima_bantuans')->where(
                    fn ($query) => $query
                        ->where('jenis_bantuan_id', $this->input('jenis_bantuan_id'))
                        ->where('tahun', $this->input('tahun'))
                ),
            ],
            'keterangan' => ['nullable', 'string'],
            // Rupiah tanpa titik/koma
            'nominal' => ['required', 'integer', 'min:0'],
            'tahun' => ['required', 'integer', 'min:2000', 'max:2100'],
            // Bulan 1-12; kosong untuk bantuan tahunan
            'bulan' => ['nullable', 'integer', 'min:1', 'max:12'],
        ];
    }
}
