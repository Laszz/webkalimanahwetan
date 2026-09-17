<?php

// Validasi biodata warga baru

namespace App\Http\Requests\Warga;

use Illuminate\Foundation\Http\FormRequest;

class StoreWargaRequest extends FormRequest
{
    // Hanya user login yang boleh isi biodata (route juga dikunci auth)
    public function authorize(): bool
    {
        return auth()->check();
    }

    // Aturan validasi kolom biodata
    public function rules(): array
    {
        return [
            // NIK 16 digit; duplikat dicek manual karena kolom terenkripsi (lihat model Warga)
            'nik' => ['required', 'digits:16'],
            'no_kk' => ['required', 'string', 'max:18'],
            'nama' => ['required', 'string', 'max:255'],
            'tempat_lahir' => ['nullable', 'string', 'max:255'],
            'tanggal_lahir' => ['nullable', 'date', 'before:today'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'alamat' => ['required', 'string'],
            'rt' => ['required', 'string', 'max:3'],
            'rw' => ['required', 'string', 'max:3'],
            'dusun' => ['required', 'string', 'max:255'],
            'agama' => ['required', 'string', 'max:30'],
            'status_kawin' => ['required', 'string', 'max:30'],
            'pekerjaan' => ['nullable', 'string', 'max:255'],
        ];
    }
}
