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
            'no_kk' => ['required', 'digits:16'],
            'nama' => ['required', 'string', 'max:255'],
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'alamat' => ['required', 'string'],
            'rt' => ['required', 'string', 'max:3'],
            'rw' => ['required', 'string', 'max:3'],
            'agama' => ['required', 'in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu'],
            'status_kawin' => ['required', 'in:Belum Menikah,Menikah,Cerai Hidup,Cerai Mati'],
            'pekerjaan' => ['nullable', 'string', 'max:255'],
            // Nomor telepon aktif untuk dihubungi perangkat desa
            'telepon' => ['nullable', 'string', 'max:20'],
            // Foto profil opsional, maksimal 2MB
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }

    // Pesan error bahasa Indonesia
    public function messages(): array
    {
        return [
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus 16 digit.',
            'no_kk.required' => 'No. KK wajib diisi.',
            'no_kk.digits' => 'No. KK harus 16 digit.',
            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama maksimal 255 karakter.',
            'tempat_lahir.required' => 'Silahkan masukkan tempat lahir.',
            'tanggal_lahir.required' => 'Silahkan isi tanggal lahir.',
            'tanggal_lahir.date' => 'Tanggal lahir tidak valid.',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin tidak valid.',
            'alamat.required' => 'Alamat wajib diisi.',
            'rt.required' => 'RT wajib diisi.',
            'rw.required' => 'RW wajib diisi.',
            'agama.required' => 'Agama wajib dipilih.',
            'agama.in' => 'Agama tidak valid.',
            'status_kawin.required' => 'Status pernikahan wajib dipilih.',
            'status_kawin.in' => 'Status pernikahan tidak valid.',
            'foto.image' => 'Foto harus berupa gambar.',
            'foto.mimes' => 'Foto harus jpg atau png.',
            'foto.max' => 'Foto maksimal 2MB.',
        ];
    }
}
