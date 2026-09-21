{{-- Halaman aduan - cari + hero terbaru + daftar sebelumnya (pakai layout warga) --}}
@extends('layouts.warga')

{{-- Judul tab browser --}}
@section('title', 'Aduan - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/warga/aduan/index.css'])
@endpush

@section('content')
    {{-- Daftar aduan; tamu diarahkan login saat klik buat/lihat --}}
    <section class="page-container aduan" aria-labelledby="aduan-judul">
        <h1 id="aduan-judul">{{ $judul }}</h1>
        <p class="aduan-sub">{{ $sub }}</p>
        <a class="btn-tambah" href="{{ auth()->check() ? route('warga.aduan.create') : route('login') }}">Buat Aduan</a>

        {{-- Kolom pencarian judul/isi --}}
        <form class="cari-bar" method="GET" action="{{ route('warga.aduan.index') }}" role="search">
            <div class="cari-field">
                <label class="sr-only" for="q">Cari aduan</label>
                <input id="q" type="search" name="q" value="{{ $cari }}" placeholder="Cari aduan..." autocomplete="off">
            </div>
            <button type="submit" class="btn-cari">Cari</button>
            @if ($cari !== '')
                <a class="btn-reset" href="{{ route('warga.aduan.index') }}">Reset</a>
            @endif
        </form>

        @if ($cari !== '')
            {{-- Hasil pencarian tampil datar semua --}}
            <h2 class="aduan-label">Hasil pencarian "{{ $cari }}"</h2>
            <ul class="aduan-list">
                @forelse ($aduans as $aduan)
                    <li>
                        <img src="{{ $aduan->gambar ? asset('storage/' . $aduan->gambar) : 'https://picsum.photos/seed/kalimanah-aduan-' . $aduan->id . '/640/360' }}" width="480" height="320" loading="lazy" alt="{{ $aduan->judul }}">
                        <div>
                            {{-- Tanggal + status --}}
                            <p class="aduan-tanggal">{{ $aduan->created_at->format('d M Y') }} · <span class="status status-{{ $aduan->status }}">{{ ucfirst($aduan->status) }}</span></p>
                            {{-- Judul + ringkasan + tombol lihat --}}
                            <h3>{{ $aduan->judul }}</h3>
                            <p>{{ \Illuminate\Support\Str::limit($aduan->isi, 100) }}</p>
                            <a class="btn-lihat" href="{{ route('warga.aduan.show', $aduan) }}">Lihat</a>
                        </div>
                    </li>
                @empty
                    {{-- Tidak cocok dengan kata kunci --}}
                    <li><p><strong>Tidak ada aduan yang cocok.</strong></p></li>
                @endforelse
            </ul>
        @else
            @if ($aduanTerbaru)
                {{-- Aduan paling baru tampil besar di atas --}}
                <h2 class="aduan-label">Aduan Terbaru</h2>
                <article class="aduan-hero">
                    <img src="{{ $aduanTerbaru->gambar ? asset('storage/' . $aduanTerbaru->gambar) : 'https://picsum.photos/seed/kalimanah-aduan-' . $aduanTerbaru->id . '/960/540' }}" width="960" height="540" fetchpriority="high" alt="{{ $aduanTerbaru->judul }}">
                    <div>
                        <p class="aduan-tanggal">{{ $aduanTerbaru->created_at->format('d M Y') }} · <span class="status status-{{ $aduanTerbaru->status }}">{{ ucfirst($aduanTerbaru->status) }}</span></p>
                        <h2>{{ $aduanTerbaru->judul }}</h2>
                        <p>{{ \Illuminate\Support\Str::limit($aduanTerbaru->isi, 150) }}</p>
                        <a class="btn-lihat" href="{{ route('warga.aduan.show', $aduanTerbaru) }}">Lihat</a>
                    </div>
                </article>
            @endif

            {{-- Aduan sebelum-sebelumnya --}}
            <h2 class="aduan-label">Aduan Sebelumnya</h2>
            <ul class="aduan-list">
                @forelse ($aduans as $aduan)
                    <li>
                        <img src="{{ $aduan->gambar ? asset('storage/' . $aduan->gambar) : 'https://picsum.photos/seed/kalimanah-aduan-' . $aduan->id . '/640/360' }}" width="480" height="320" loading="lazy" alt="{{ $aduan->judul }}">
                        <div>
                            {{-- Tanggal + status --}}
                            <p class="aduan-tanggal">{{ $aduan->created_at->format('d M Y') }} · <span class="status status-{{ $aduan->status }}">{{ ucfirst($aduan->status) }}</span></p>
                            {{-- Judul + ringkasan + tombol lihat --}}
                            <h3>{{ $aduan->judul }}</h3>
                            <p>{{ \Illuminate\Support\Str::limit($aduan->isi, 100) }}</p>
                            <a class="btn-lihat" href="{{ route('warga.aduan.show', $aduan) }}">Lihat</a>
                        </div>
                    </li>
                @empty
                    {{-- Belum pernah melapor --}}
                    <li><p><strong>Belum ada aduan.</strong></p></li>
                @endforelse
            </ul>
        @endif

        {{-- Navigasi halaman (bawa kata kunci) --}}
        {{ $aduans->links() }}
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/warga/aduan/index.js'])
@endpush
