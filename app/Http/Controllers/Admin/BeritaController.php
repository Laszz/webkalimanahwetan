<?php

// Controller berita sisi ADMIN - kelola kabar dan pengumuman desa

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBeritaRequest;
use App\Http\Requests\Admin\UpdateBeritaRequest;
use App\Models\Berita;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BeritaController extends Controller
{
    // Semua berita + penulis, terbaru dulu 15 per halaman
    public function index(): View
    {
        $beritas = Berita::with('user:id,name')->latest()->paginate(15);

        return view('admin.berita.index', compact('beritas'));
    }

    // Form tulis berita baru
    public function create(): View
    {
        return view('admin.berita.create');
    }

    // Simpan berita; penulis otomatis admin login, slug dibuat dari judul
    public function store(StoreBeritaRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $this->slugUnik($data['judul']);

        // Pindahkan gambar sampul ke storage jika ada
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $berita = auth()->user()->beritas()->create($data);

        return redirect()
            ->route('admin.berita.show', $berita)
            ->with('success', 'Berita tersimpan.');
    }

    // Detail satu berita
    public function show(Berita $berita): View
    {
        return view('admin.berita.show', compact('berita'));
    }

    // Form ubah berita
    public function edit(Berita $berita): View
    {
        return view('admin.berita.edit', compact('berita'));
    }

    // Simpan perubahan; slug ikut baru jika judul diganti
    public function update(UpdateBeritaRequest $request, Berita $berita): RedirectResponse
    {
        $data = $request->validated();

        if ($data['judul'] !== $berita->judul) {
            $data['slug'] = $this->slugUnik($data['judul'], $berita->id);
        }

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $berita->update($data);

        return redirect()
            ->route('admin.berita.show', $berita)
            ->with('success', 'Berita diperbarui.');
    }

    // Hapus berita (lunak, masih bisa dipulihkan dari database)
    public function destroy(Berita $berita): RedirectResponse
    {
        $berita->delete();

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita dihapus.');
    }

    // Buat slug unik dari judul; tambah angka jika sudah dipakai berita lain
    private function slugUnik(string $judul, ?int $kecualiId = null): string
    {
        $dasar = Str::slug($judul);
        $slug = $dasar;
        $nomor = 2;

        while (Berita::where('slug', $slug)->when($kecualiId, fn ($q) => $q->where('id', '!=', $kecualiId))->exists()) {
            $slug = $dasar . '-' . $nomor++;
        }

        return $slug;
    }
}
