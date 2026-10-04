{{-- Sambutan kepala desa - dipakai welcome + dashboard warga; sembunyi jika data kosong --}}
@if (! empty($kepalaDesa) || ! empty($profil->sambutan ?? null))
    <section class="sambutan" id="sambutan" aria-labelledby="sambutan-judul">
        <div class="page-container sambutan-inner">
            {{-- Foto kepala desa --}}
            <figure class="sambutan-foto">
                <img src="{{ ! empty($kepalaDesa?->foto) ? asset('storage/' . $kepalaDesa->foto) : 'https://picsum.photos/seed/kalimanah-kades/480/600' }}" width="480" height="600" loading="lazy" alt="Foto {{ $kepalaDesa->nama ?? 'Kepala Desa' }}">
            </figure>
            {{-- Teks sambutan --}}
            <div class="sambutan-teks">
                <p class="hero-kicker">Sambutan</p>
                <h2 id="sambutan-judul" class="judul-seksi judul-kiri">Kepala Desa</h2>
                <div class="pra">{!! nl2br(e($profil->sambutan ?? 'Selamat datang di website resmi Desa Kalimanah. Melalui situs ini kami menghadirkan layanan administrasi yang mudah, transparan, dan dekat dengan warga.')) !!}</div>
                @if (! empty($kepalaDesa))
                    <p class="sambutan-nama"><strong>{{ $kepalaDesa->nama }}</strong><span>{{ $kepalaDesa->jabatan }}</span></p>
                @endif
            </div>
        </div>
    </section>
@endif
