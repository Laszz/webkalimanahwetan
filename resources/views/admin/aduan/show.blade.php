{{-- Halaman detail aduan + ubah status + tanggapan (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Detail Aduan - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/aduan/show.css'])
@endpush

@section('content')
    {{-- Isi aduan --}}
    <section class="detail" aria-labelledby="aduan-judul">
        <h1 id="aduan-judul">{{ $aduan->judul }}</h1>
        {{-- Baris status + pelapor + tanggal --}}
        <p class="detail-meta">
            <span class="status status-{{ $aduan->status }}">{{ ucfirst($aduan->status) }}</span>
            <span>{{ $aduan->user->name ?? '-' }} · {{ $aduan->created_at->format('d M Y H.i') }}</span>
        </p>
        <p class="detail-isi">{{ $aduan->isi }}</p>

        {{-- Foto bukti jika ada --}}
        @if ($aduan->gambar)
            <figure class="detail-foto">
                <img src="{{ asset('storage/' . $aduan->gambar) }}" alt="Foto bukti aduan">
            </figure>
        @endif

        {{-- Form ubah status tindak lanjut --}}
        <h2 class="kartu-judul">Ubah Status</h2>
        <form class="form-baru" method="POST" action="{{ route('admin.aduan.update', $aduan) }}">
            @csrf
            @method('PUT')
            <div class="field">
                <label for="status">Status</label>
                <select id="status" name="status" required>
                    <option value="menunggu" @selected($aduan->status === 'menunggu')>Menunggu</option>
                    <option value="diproses" @selected($aduan->status === 'diproses')>Diproses</option>
                    <option value="selesai" @selected($aduan->status === 'selesai')>Selesai</option>
                </select>
            </div>
            <button type="submit" class="btn-simpan">Simpan Status</button>
        </form>

        {{-- Daftar tanggapan admin --}}
        <h2 class="kartu-judul">Tanggapan</h2>
        <ul class="tanggapan-list">
            @forelse ($aduan->tanggapanAduan as $tanggapan)
                <li>
                    {{-- Isi + penanggap + waktu --}}
                    <p>{{ $tanggapan->isi }}</p>
                    <span>{{ $tanggapan->user->name ?? '-' }} · {{ $tanggapan->created_at->format('d M Y H.i') }}</span>
                    {{-- Hapus tanggapan ini --}}
                    <form method="POST" action="{{ route('admin.tanggapan.destroy', $tanggapan) }}" data-konfirmasi="Hapus tanggapan ini?">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-kecil btn-hapus">Hapus</button>
                    </form>
                </li>
            @empty
                {{-- Belum ada tanggapan --}}
                <li class="kosong">Belum ada tanggapan.</li>
            @endforelse
        </ul>

        {{-- Form tambah tanggapan baru --}}
        <h3 class="kartu-judul">Tambah Tanggapan</h3>
        <form class="form-baru" method="POST" action="{{ route('admin.tanggapan.store', $aduan) }}">
            @csrf
            <div class="field">
                <label for="isi">Isi Tanggapan</label>
                <textarea id="isi" name="isi" rows="3" required>{{ old('isi') }}</textarea>
            </div>
            <button type="submit" class="btn-simpan">Kirim</button>
        </form>

        {{-- Tombol kembali ke daftar --}}
        <div class="aksi-bawah">
            <a class="btn-sekunder" href="{{ route('admin.aduan.index') }}">Kembali</a>
        </div>
    </section>

    {{-- Popup hasil aksi (tampil jika ada pesan sesi) --}}
    @if (session('success'))
        <div class="popup" id="popup" role="alertdialog" aria-modal="true" aria-label="Hasil aksi">
            <div class="popup-kartu">
                <i class="ph ph-check-circle popup-ok" aria-hidden="true"></i>
                <p>{{ session('success') }}</p>
                <button type="button" class="btn-kecil btn-setuju" data-tutup>Tutup</button>
            </div>
        </div>
    @endif
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/admin/aduan/show.js'])
@endpush
