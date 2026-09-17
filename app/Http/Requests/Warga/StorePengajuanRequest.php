<?php

// Validasi pengajuan surat baru; aturan syarat dibangun dinamis dari layanan yang dipilih

namespace App\Http\Requests\Warga;

use App\Models\Layanan;
use Illuminate\Foundation\Http\FormRequest;

class StorePengajuanRequest extends FormRequest
{
    // Hanya user login yang boleh mengajukan (route juga dikunci auth)
    public function authorize(): bool
    {
        return auth()->check();
    }

    // Aturan validasi: layanan + keperluan + satu aturan per syarat layanan
    public function rules(): array
    {
        $rules = [
            'layanan_id' => ['required', 'exists:layanans,id'],
            'keperluan' => ['nullable', 'string'],
        ];

        // Tambah aturan tiap syarat: file wajib/opsional atau teks wajib/opsional
        $layanan = Layanan::with('syaratLayanan')->find($this->input('layanan_id'));

        if ($layanan) {
            foreach ($layanan->syaratLayanan as $syarat) {
                $wajib = $syarat->wajib ? 'required' : 'nullable';
                $rules["syarat.{$syarat->id}"] = $syarat->tipe === 'file'
                    ? [$wajib, 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048']
                    : [$wajib, 'string', 'max:1000'];
            }
        }

        return $rules;
    }
}
