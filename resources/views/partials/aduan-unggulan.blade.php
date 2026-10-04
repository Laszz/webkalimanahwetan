{{-- Seksi ADUAN pola sorotan: 1 utama besar + daftar mini (dipakai welcome + dashboard) --}}
<section class="aduan" id="aduan" aria-labelledby="aduan-judul">
    <div class="page-container">
        <h2 id="aduan-judul" class="judul-seksi">Aduan Terbaru Warga</h2>
        <p class="sub-seksi">Laporan yang masuk dan sedang ditindaklanjuti perangkat desa.</p>
        @php $daftar = collect($aduans ?? []); @endphp
        @if ($daftar->isNotEmpty())
            @php $utama = $daftar->first(); @endphp
            <div class="unggulan-wrap">
                {{-- Kartu utama: foto besar + judul menumpuk di atas foto --}}
                <a class="unggulan-utama" href="{{ route('warga.aduan.show', $utama) }}">
                    <img src="{{ $utama->gambar ? asset('storage/' . $utama->gambar) : 'https://picsum.photos/seed/kalimanah-aduan-' . $utama->id . '/800/500' }}" width="800" height="500" loading="lazy" alt="{{ $utama->judul }}">
                    <span class="unggulan-overlay">
                        <span class="unggulan-judul">{{ $utama->judul }}</span>
                        <span class="unggulan-tanggal"><i class="ph ph-calendar" aria-hidden="true"></i>{{ $utama->created_at->format('d F Y') }}</span>
                        <span class="aduan-status-teks">{{ ucfirst($utama->status) }}</span>
                    </span>
                </a>
                {{-- Daftar mini: foto kecil + tanggal + judul + status --}}
                <ul class="unggulan-list">
                    @foreach ($daftar->skip(1) as $aduan)
                        <li>
                            <a href="{{ route('warga.aduan.show', $aduan) }}">
                                <img src="{{ $aduan->gambar ? asset('storage/' . $aduan->gambar) : 'https://picsum.photos/seed/kalimanah-aduan-' . $aduan->id . '/240/180' }}" width="240" height="180" loading="lazy" alt="{{ $aduan->judul }}">
                                <span class="unggulan-mini-badan">
                                    <span class="unggulan-mini-judul">{{ \Illuminate\Support\Str::limit($aduan->judul, 70) }}</span>
                                    <span class="unggulan-tanggal"><i class="ph ph-calendar" aria-hidden="true"></i>{{ $aduan->created_at->format('d F Y') }}</span>
                                    <span class="aduan-status-teks">{{ ucfirst($aduan->status) }}</span>
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            {{-- Belum ada aduan masuk --}}
            <p class="kosong-tengah"><strong>Belum ada aduan.</strong><span>Jadilah pelapor pertama.</span></p>
        @endif
    </div>
</section>
