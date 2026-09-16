{{-- Agenda kegiatan desa - dipakai welcome + dashboard warga --}}
{{-- TODO: ganti daftar statis di bawah dengan agenda terdekat dari database --}}
<section class="agenda" id="agenda" aria-labelledby="agenda-judul">
    <div class="page-container">
        <h2 id="agenda-judul" class="judul-seksi">Agenda Kegiatan</h2>
        <p class="sub-seksi">Jadwal terdekat yang bisa diikuti warga.</p>
        <ul class="agenda-list">
            {{-- Tiap baris: penanda tanggal + nama kegiatan + tempat dan waktu (data contoh) --}}
            <li>
                <p class="agenda-tanggal"><strong>20</strong><span>Sep</span></p>
                <div><h3>Musyawarah Dusun IV</h3><p>Balai Dusun IV, pukul 19.00</p></div>
            </li>
            <li>
                <p class="agenda-tanggal"><strong>27</strong><span>Sep</span></p>
                <div><h3>Posyandu Balita</h3><p>Balai Dusun II, pukul 08.00</p></div>
            </li>
            <li>
                <p class="agenda-tanggal"><strong>05</strong><span>Okt</span></p>
                <div><h3>Kerja Bakti Lingkungan</h3><p>Titik kumpul Balai Desa, pukul 07.00</p></div>
            </li>
        </ul>
    </div>
</section>
