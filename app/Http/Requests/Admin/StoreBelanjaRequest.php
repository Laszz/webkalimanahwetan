<?php

// Validasi belanja baru oleh admin (nominal tidak boleh melebihi sisa dana)

namespace App\Http\Requests\Admin;

use App\Models\Belanja;
use App\Models\Dana;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBelanjaRequest extends FormRequest
{
    // Hanya admin yang boleh kelola belanja (route juga dikunci admin)
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    // Aturan validasi kolom belanja
    public function rules(): array
    {
        return [
            'dana_id' => ['required', 'exists:danas,id'],
            'bidang' => ['required', 'string', Rule::in(Belanja::BIDANG)],
            'uraian' => ['required', 'string', 'max:255'],
            // Rupiah tanpa titik/koma, tidak boleh melebihi sisa dana
            'nominal' => ['required', 'integer', 'min:0', function ($atribut, $nilai, $gagal) {
                $dana = Dana::find($this->input('dana_id'));
                if (! $dana) {
                    return;
                }
                $sisa = $dana->anggaran - $dana->belanjas()->sum('nominal');
                if ($nilai > $sisa) {
                    $gagal('Nominal melebihi sisa dana Rp' . number_format(max(0, $sisa), 0, ',', '.') . '.');
                }
            }],
        ];
    }

    // Pesan Indonesia
    public function messages(): array
    {
        return [
            'dana_id.required' => 'Silahkan pilih dana yang dipakai.',
        ];
    }
}
