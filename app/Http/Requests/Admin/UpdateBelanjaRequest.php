<?php

// Validasi ubah belanja oleh admin (sisa dihitung tanpa baris sendiri)

namespace App\Http\Requests\Admin;

use App\Models\Belanja;
use App\Models\Dana;
use Illuminate\Validation\Rule;

class UpdateBelanjaRequest extends StoreBelanjaRequest
{
    // Aturan validasi + sisa tanpa nominal lama baris ini
    public function rules(): array
    {
        return [
            'dana_id' => ['required', 'exists:danas,id'],
            'bidang' => ['required', 'string', Rule::in(Belanja::BIDANG)],
            'uraian' => ['required', 'string', 'max:255'],
            'nominal' => ['required', 'integer', 'min:0', function ($atribut, $nilai, $gagal) {
                $dana = Dana::find($this->input('dana_id'));
                if (! $dana) {
                    return;
                }
                // Keluarkan nominal lama agar pindah dana / naik nominal dihitung adil
                $terpakaiLain = $dana->belanjas()->where('id', '!=', $this->route('belanja')->id)->sum('nominal');
                $sisa = $dana->anggaran - $terpakaiLain;
                if ($nilai > $sisa) {
                    $gagal('Nominal melebihi sisa dana Rp' . number_format(max(0, $sisa), 0, ',', '.') . '.');
                }
            }],
        ];
    }
}
