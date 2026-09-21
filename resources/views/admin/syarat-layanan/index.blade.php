{{-- Halaman syarat satu layanan - daftar + tambah/hapus (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Syarat Layanan - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/syarat-layanan/index.css'])
@endpush

@section('content')
    {{-- Syarat milik layanan terpilih --}}
    <section class="detail" aria-labelledby="syarat-judul">
        <h1 id="syarat-judul">Syarat: {{ $layanan->nama }}</h1>
        <p class="detail-sub">Syarat yang harus dipenuhi warga untuk layanan ini.</p>

        {{-- Daftar syarat di atas --}}
        <h2 class="kartu-judul">Daftar Syarat</h2>
        <ul class="syarat-list">
            @forelse ($layanan->syaratLayanan as $syarat)
                <li>
                    {{-- Nama + tipe --}}
                    <div class="syarat-head">
                        <strong>{{ $syarat->nama }}</strong>
                        <span class="syarat-meta">{{ $syarat->tipe === 'file' ? 'File' : 'Teks' }}</span>
                    </div>
                    {{-- Hapus syarat ini --}}
                    <form method="POST" action="{{ route('admin.syarat-layanan.destroy', $syarat) }}" data-konfirmasi="Hapus syarat {{ $syarat->nama }}?">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-kecil btn-hapus">Hapus</button>
                    </form>
                </li>
            @empty
                {{-- Belum ada syarat --}}
                <li class="kosong">Belum ada syarat.</li>
            @endforelse
        </ul>

        {{-- Form tambah syarat baru di bawah dan rata tengah --}}
        <h2 class="kartu-judul">Tambah Syarat</h2>
        <form class="form-card form-tengah" method="POST" action="{{ route('admin.syarat-layanan.store') }}">
            @csrf
            {{-- Layanan pemilik (tersembunyi, dari halaman ini) --}}
            <input type="hidden" name="layanan_id" value="{{ $layanan->id }}">
            <div class="field">
                <label for="nama">Nama Syarat</label>
                <input id="nama" type="text" name="nama" value="{{ old('nama') }}" required autocomplete="off">
                @foreach ((array) $errors->get('nama') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            <div class="field">
                <label for="tipe">Tipe Jawaban</label>
                <select id="tipe" name="tipe" required>
                    <option value="file" @selected(old('tipe') === 'file')>File</option>
                    <option value="text" @selected(old('tipe') === 'text')>Teks</option>
                </select>
                @foreach ((array) $errors->get('tipe') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Baris tombol tambah + kembali sejajar --}}
            <div class="aksi-baris">
                <button type="submit" class="btn-simpan">Tambah</button>
                <a class="btn-sekunder" href="{{ route('admin.layanan.index') }}">Kembali</a>
            </div>
        </form>
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
    @vite(['resources/js/admin/syarat-layanan/index.js'])
@endpush
