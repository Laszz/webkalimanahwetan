{{-- Kartu 5 aduan terbaru dari warga - dipakai welcome + dashboard warga --}}
{{-- TODO: ganti daftar statis di bawah dengan 5 aduan terbaru dari database --}}
<section class="aduan" id="aduan" aria-labelledby="aduan-judul">
    <div class="page-container">
        <h2 id="aduan-judul" class="judul-seksi">Aduan Terbaru Warga</h2>
        <p class="sub-seksi">Laporan yang masuk dan sedang ditindaklanjuti perangkat desa.</p>
        <ul class="aduan-list">
            {{-- Tiap baris: judul aduan + tanggal + status (data contoh) --}}
            <li>
                <div><strong>Jalan rusak di Dusun II</strong><span>12 Sep 2026</span></div>
                <span class="status status-diproses">Diproses</span>
            </li>
            <li>
                <div><strong>Lampu jalan mati RT 03 RW 01</strong><span>11 Sep 2026</span></div>
                <span class="status status-menunggu">Menunggu</span>
            </li>
            <li>
                <div><strong>Sampah menumpuk dekat sungai</strong><span>09 Sep 2026</span></div>
                <span class="status status-diproses">Diproses</span>
            </li>
            <li>
                <div><strong>Air bersih tersendat Dusun V</strong><span>07 Sep 2026</span></div>
                <span class="status status-selesai">Selesai</span>
            </li>
            <li>
                <div><strong>Pos ronda perlu perbaikan</strong><span>05 Sep 2026</span></div>
                <span class="status status-selesai">Selesai</span>
            </li>
        </ul>
    </div>
</section>
