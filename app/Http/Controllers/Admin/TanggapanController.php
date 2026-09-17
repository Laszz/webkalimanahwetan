<?php

// Controller tanggapan aduan sisi ADMIN - balas laporan warga per aduan

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTanggapanRequest;
use App\Models\Aduan;
use App\Models\TanggapanAduan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TanggapanController extends Controller
{
    // Tambah balasan pada aduan tertentu; penanggap otomatis admin login
    public function store(StoreTanggapanRequest $request, Aduan $aduan): RedirectResponse
    {
        $aduan->tanggapanAduan()->create([
            'user_id' => $request->user()->id,
            'isi' => $request->validated()['isi'],
        ]);

        return redirect()
            ->route('admin.aduan.show', $aduan)
            ->with('success', 'Tanggapan terkirim.');
    }

    // Ubah isi balasan
    public function update(Request $request, TanggapanAduan $tanggapan): RedirectResponse
    {
        // Satu-satunya input: isi balasan baru
        $data = $request->validate([
            'isi' => ['required', 'string'],
        ]);

        $tanggapan->update($data);

        return redirect()
            ->route('admin.aduan.show', $tanggapan->aduan_id)
            ->with('success', 'Tanggapan diperbarui.');
    }

    // Hapus balasan
    public function destroy(TanggapanAduan $tanggapan): RedirectResponse
    {
        $aduanId = $tanggapan->aduan_id;
        $tanggapan->delete();

        return redirect()
            ->route('admin.aduan.show', $aduanId)
            ->with('success', 'Tanggapan dihapus.');
    }
}
