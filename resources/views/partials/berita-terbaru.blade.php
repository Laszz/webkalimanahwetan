{{-- 5 berita terbaru - dipakai welcome + dashboard warga --}}
{{-- TODO: ganti daftar statis di bawah dengan 5 berita terbaru dari database --}}
<section class="berita" aria-labelledby="berita-judul">
    <div class="page-container">
        <h2 id="berita-judul" class="judul-seksi">Berita dan Pengumuman</h2>
        <ul class="berita-list">
            {{-- Tiap baris: foto + tanggal + judul + ringkasan (foto picsum sebagai placeholder) --}}
            <li>
                <img src="https://picsum.photos/seed/kalimanah-berita-1/480/320" width="480" height="320" loading="lazy" alt="Musyawarah warga Dusun IV">
                <div>
                    <p class="berita-tanggal">10 Sep 2026</p>
                    <h3><a href="#">Musyawarah Dusun IV</a></h3>
                    <p>Pembahasan perbaikan jalan lingkungan dan pos ronda.</p>
                </div>
            </li>
            <li>
                <img src="https://picsum.photos/seed/kalimanah-berita-2/480/320" width="480" height="320" loading="lazy" alt="Kegiatan posyandu balita">
                <div>
                    <p class="berita-tanggal">02 Sep 2026</p>
                    <h3><a href="#">Posyandu Balita</a></h3>
                    <p>Jadwal penimbangan dan imunisasi di balai dusun.</p>
                </div>
            </li>
            <li>
                <img src="https://picsum.photos/seed/kalimanah-berita-3/480/320" width="480" height="320" loading="lazy" alt="Pelayanan administrasi desa">
                <div>
                    <p class="berita-tanggal">25 Agu 2026</p>
                    <h3><a href="#">Pemutihan Administrasi</a></h3>
                    <p>Periode pembaruan data KK gratis sampai akhir bulan.</p>
                </div>
            </li>
            <li>
                <img src="https://picsum.photos/seed/kalimanah-berita-4/480/320" width="480" height="320" loading="lazy" alt="Karnaval peringatan kemerdekaan">
                <div>
                    <p class="berita-tanggal">17 Agu 2026</p>
                    <h3><a href="#">Karnaval HUT RI</a></h3>
                    <p>Pawai budaya keliling desa memeriahkan kemerdekaan.</p>
                </div>
            </li>
            <li>
                <img src="https://picsum.photos/seed/kalimanah-berita-5/480/320" width="480" height="320" loading="lazy" alt="Penyemprotan fogging pencegahan DBD">
                <div>
                    <p class="berita-tanggal">10 Agu 2026</p>
                    <h3><a href="#">Fogging Pencegahan DBD</a></h3>
                    <p>Penyemprotan serentak di semua dusun mulai pukul 06.00.</p>
                </div>
            </li>
        </ul>
    </div>
</section>
