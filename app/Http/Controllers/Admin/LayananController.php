<?php

// Controller master layanan sisi ADMIN - kelola jenis surat + syaratnya

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLayananRequest;
use App\Http\Requests\Admin\UpdateLayananRequest;
use App\Models\Layanan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LayananController extends Controller
{
    // Semua layanan + jumlah syarat, terbaru dulu 15 per halaman
    public function index(): View
    {
        $layanans = Layanan::withCount('syaratLayanan')->latest()->paginate(15);

        return view('admin.layanan.index', compact('layanans'));
    }

    // Form tambah layanan baru
    public function create(): View
    {
        return view('admin.layanan.create');
    }

    // Simpan layanan + syarat bawaannya dalam satu transaksi
    public function store(StoreLayananRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $layanan = DB::transaction(function () use ($data) {
            // Induk layanan dulu
            $layanan = Layanan::create([
                'nama' => $data['nama'],
                'deskripsi' => $data['deskripsi'] ?? null,
                'estimasi_hari' => $data['estimasi_hari'] ?? null,
            ]);

            // Syarat bawaan jika diisi di form
            foreach ($data['syarat'] ?? [] as $syarat) {
                $layanan->syaratLayanan()->create([
                    'nama' => $syarat['nama'],
                    'tipe' => $syarat['tipe'],
                    'wajib' => $syarat['wajib'] ?? false,
                ]);
            }

            return $layanan;
        });

        return redirect()
            ->route('admin.layanan.show', $layanan)
            ->with('success', 'Layanan tersimpan.');
    }

    // Detail layanan + daftar syaratnya
    public function show(Layanan $layanan): View
    {
        $layanan->load('syaratLayanan');

        return view('admin.layanan.show', compact('layanan'));
    }

    // Form ubah layanan
    public function edit(Layanan $layanan): View
    {
        $layanan->load('syaratLayanan');

        return view('admin.layanan.edit', compact('layanan'));
    }

    // Simpan perubahan layanan; syarat diatur ulang mengikuti form
    public function update(UpdateLayananRequest $request, Layanan $layanan): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($data, $layanan) {
            $layanan->update([
                'nama' => $data['nama'],
                'deskripsi' => $data['deskripsi'] ?? null,
                'estimasi_hari' => $data['estimasi_hari'] ?? null,
                // Checkbox tidak terkirim saat tidak dicentang = nonaktif
                'aktif' => $request->boolean('aktif'),
            ]);

            // Ganti seluruh syarat lama dengan isi form terbaru
            $layanan->syaratLayanan()->delete();

            foreach ($data['syarat'] ?? [] as $syarat) {
                $layanan->syaratLayanan()->create([
                    'nama' => $syarat['nama'],
                    'tipe' => $syarat['tipe'],
                    'wajib' => $syarat['wajib'] ?? false,
                ]);
            }
        });

        return redirect()
            ->route('admin.layanan.show', $layanan)
            ->with('success', 'Layanan diperbarui.');
    }

    // Hapus layanan (syarat ikut terhapus via cascade)
    public function destroy(Layanan $layanan): RedirectResponse
    {
        $layanan->delete();

        return redirect()
            ->route('admin.layanan.index')
            ->with('success', 'Layanan dihapus.');
    }
}
