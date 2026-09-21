{{-- Halaman berita - cari + hero terbaru + daftar sebelumnya (pakai layout warga) --}}
@extends('layouts.warga')

{{-- Judul tab browser --}}
@section('title', 'Berita - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/warga/berita/index.css'])
@endpush

@section('content')
    {{-- Daftar berita terbit --}}
    <section class="page-container berita" aria-labelledby="berita-judul">
        <h1 id="berita-judul">Berita Desa</h1>
        <p class="berita-sub">Kabar dan pengumuman terbaru.</p>

        {{-- Kolom pencarian judul/ringkasan/isi --}}
        <form class="cari-bar" method="GET" action="{{ route('warga.berita.index') }}" role="search">
            <div class="cari-field">
                <label class="sr-only" for="q">Cari berita</label>
                <input id="q" type="search" name="q" value="{{ $cari }}" placeholder="Cari berita..." autocomplete="off">
            </div>
            <button type="submit" class="btn-cari">Cari</button>
            @if ($cari !== '')
                <a class="btn-reset" href="{{ route('warga.berita.index') }}">Reset</a>
            @endif
        </form>

        @if ($cari !== '')
            {{-- Hasil pencarian tampil datar semua --}}
            <h2 class="berita-label">Hasil pencarian "{{ $cari }}"</h2>
            <ul class="berita-list">
                @forelse ($beritas as $berita)
                    <li>
                        @if ($berita->gambar)
                            <img src="{{ asset('storage/' . $berita->gambar) }}" width="480" height="320" loading="lazy" alt="{{ $berita->judul }}">
                        @endif
                        <div>
                            {{-- Tanggal terbit --}}
                            <p class="berita-tanggal">{{ $berita->published_at?->format('d M Y') }}</p>
                            {{-- Judul + ringkasan + tombol baca --}}
                            <h3>{{ $berita->judul }}</h3>
                            <p>{{ $berita->ringkasan ?? '' }}</p>
                            <a class="btn-baca" href="{{ route('warga.berita.show', $berita->slug) }}">Baca</a>
                        </div>
                    </li>
                @empty
                    {{-- Tidak cocok dengan kata kunci --}}
                    <li><p><strong>Tidak ada berita yang cocok.</strong></p></li>
                @endforelse
            </ul>
        @else
            @if ($beritaTerbaru)
                {{-- Label + berita paling baru di atas --}}
                <h2 class="berita-label">Berita Terbaru</h2>
                <article class="berita-hero">
                    @if ($beritaTerbaru->gambar)
                        <img src="{{ asset('storage/' . $beritaTerbaru->gambar) }}" width="960" height="540" fetchpriority="high" alt="{{ $beritaTerbaru->judul }}">
                    @endif
                    <div>
                        <p class="berita-tanggal">{{ $beritaTerbaru->published_at?->format('d M Y') }} · Terbaru</p>
                        <h2>{{ $beritaTerbaru->judul }}</h2>
                        <p>{{ $beritaTerbaru->ringkasan ?? '' }}</p>
                        <a class="btn-baca" href="{{ route('warga.berita.show', $beritaTerbaru->slug) }}">Baca</a>
                    </div>
                </article>
            @endif

            {{-- Berita sebelum-sebelumnya --}}
            <h2 class="berita-label">Berita Sebelumnya</h2>
            <ul class="berita-list">
                @forelse ($beritas as $berita)
                    <li>
                        @if ($berita->gambar)
                            <img src="{{ asset('storage/' . $berita->gambar) }}" width="480" height="320" loading="lazy" alt="{{ $berita->judul }}">
                        @endif
                        <div>
                            {{-- Tanggal terbit --}}
                            <p class="berita-tanggal">{{ $berita->published_at?->format('d M Y') }}</p>
                            {{-- Judul + ringkasan + tombol baca --}}
                            <h3>{{ $berita->judul }}</h3>
                            <p>{{ $berita->ringkasan ?? '' }}</p>
                            <a class="btn-baca" href="{{ route('warga.berita.show', $berita->slug) }}">Baca</a>
                        </div>
                    </li>
                @empty
                    {{-- Belum ada berita terbit --}}
                    <li><p><strong>Belum ada berita.</strong></p></li>
                @endforelse
            </ul>
        @endif

        {{-- Navigasi halaman (bawa kata kunci) --}}
        {{ $beritas->links() }}
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/warga/berita/index.js'])
@endpush
