{{-- Seksi BERITA pola sorotan: 1 utama besar + daftar mini (dipakai welcome + dashboard) --}}
<section class="berita" id="berita" aria-labelledby="berita-judul">
    <div class="page-container">
        <h2 id="berita-judul" class="judul-seksi">Berita dan Pengumuman</h2>
        <p class="sub-seksi">Kabar dan pengumuman terbaru desa.</p>
        @php $daftar = collect($beritas ?? []); @endphp
        @if ($daftar->isNotEmpty())
            @php $utama = $daftar->first(); @endphp
            <div class="unggulan-wrap">
                {{-- Kartu utama: foto besar + judul menumpuk di atas foto --}}
                <a class="unggulan-utama" href="{{ route('warga.berita.show', $utama->slug) }}">
                    <img src="{{ $utama->gambar ? asset('storage/' . $utama->gambar) : 'https://picsum.photos/seed/kalimanah-berita-' . $utama->id . '/800/500' }}" width="800" height="500" loading="lazy" alt="{{ $utama->judul }}">
                    <span class="unggulan-overlay">
                        <span class="unggulan-judul">{{ $utama->judul }}</span>
                        <span class="unggulan-tanggal"><i class="ph ph-calendar" aria-hidden="true"></i>{{ $utama->published_at?->format('d F Y') }}</span>
                    </span>
                </a>
                {{-- Daftar mini: foto kecil + tanggal + judul --}}
                <ul class="unggulan-list">
                    @foreach ($daftar->skip(1) as $berita)
                        <li>
                            <a href="{{ route('warga.berita.show', $berita->slug) }}">
                                <img src="{{ $berita->gambar ? asset('storage/' . $berita->gambar) : 'https://picsum.photos/seed/kalimanah-berita-' . $berita->id . '/240/180' }}" width="240" height="180" loading="lazy" alt="{{ $berita->judul }}">
                                <span class="unggulan-mini-badan">
                                    <span class="unggulan-mini-judul">{{ \Illuminate\Support\Str::limit($berita->judul, 70) }}</span>
                                    <span class="unggulan-tanggal"><i class="ph ph-calendar" aria-hidden="true"></i>{{ $berita->published_at?->format('d F Y') }}</span>
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            {{-- Belum ada berita terbit --}}
            <p class="kosong-tengah"><strong>Belum ada berita.</strong></p>
        @endif
    </div>
</section>
