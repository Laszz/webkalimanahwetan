<?php

// Controller profil sisi WARGA - isi pertama dan ubah biodata milik sendiri

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Http\Requests\Warga\StoreWargaRequest;
use App\Http\Requests\Warga\UpdateWargaRequest;
use App\Models\Warga;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WargaController extends Controller
{
    // Profil biodata sendiri; lempar ke form isi jika belum ada
    public function show(): View|RedirectResponse
    {
        $warga = auth()->user()->warga;

        if (! $warga) {
            return redirect()->route('warga.profil.create');
        }

        return view('warga.profil.show', compact('warga'));
    }

    // Form isi biodata pertama (sudah punya = lempar ke ubah)
    public function create(): View|RedirectResponse
    {
        if (auth()->user()->warga) {
            return redirect()->route('warga.profil.edit');
        }

        return view('warga.profil.create');
    }

    // Simpan biodata pertama; relasi akun diisi otomatis (bukan dari input)
    public function store(StoreWargaRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Hash NIK asli untuk cek duplikat (unique database tidak bisa baca ciphertext)
        $data['nik_hash'] = hash('sha256', $data['nik']);

        // Tolak NIK ganda dengan pesan ramah sebelum unique database menolak
        if (Warga::where('nik_hash', $data['nik_hash'])->exists()) {
            return redirect()->back()->withErrors(['nik' => 'NIK sudah terdaftar.'])->withInput();
        }

        // Pindahkan foto profil ke storage jika ada
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('warga', 'public');
        }

        auth()->user()->warga()->create($data);

        return redirect()
            ->route('warga.profil.show')
            ->with('success', 'Biodata tersimpan dan menunggu verifikasi admin.');
    }

    // Form ubah biodata sendiri
    public function edit(): View|RedirectResponse
    {
        $warga = auth()->user()->warga;

        if (! $warga) {
            return redirect()->route('warga.profil.create');
        }

        return view('warga.profil.edit', compact('warga'));
    }

    // Simpan perubahan biodata sendiri
    public function update(UpdateWargaRequest $request): RedirectResponse
    {
        $warga = auth()->user()->warga;

        if (! $warga) {
            return redirect()->route('warga.profil.create');
        }

        $data = $request->validated();

        // Hash ulang karena NIK bisa berubah
        $data['nik_hash'] = hash('sha256', $data['nik']);

        // Tolak NIK milik warga lain
        $duplikat = Warga::where('nik_hash', $data['nik_hash'])->where('id', '!=', $warga->id)->exists();

        if ($duplikat) {
            return redirect()->back()->withErrors(['nik' => 'NIK sudah terdaftar.'])->withInput();
        }

        // Ganti foto hanya jika ada unggahan baru
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('warga', 'public');
        }

        $warga->update($data);

        return redirect()
            ->route('warga.profil.show')
            ->with('success', 'Biodata diperbarui.');
    }
}
