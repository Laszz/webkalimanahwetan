{{-- Kaki halaman publik - dipakai welcome + dashboard warga (di dalam <footer> layout warga) --}}
<div class="footer-inner">
    {{-- Identitas balai desa di kiri --}}
    <div class="footer-brand-block">
        {{-- Nama balai desa sebagai teks biasa (tanpa link) --}}
        <p class="footer-brand">Balai Desa Kalimanah</p>
        <p class="footer-alamat">Kec. Kalimanah, Kab. Purbalingga</p>
    </div>
    {{-- Ikon media sosial di kanan; TODO: ganti href # dengan URL akun asli --}}
    <nav class="footer-sosmed" aria-label="Media sosial Desa Kalimanah">
        <a href="https://www.youtube.com/@pemdeskalwet" target="blank" aria-label="YouTube Desa Kalimanah"><i class="ph ph-youtube-logo" aria-hidden="true"></i></a>
        <a href="#" target="blank" aria-label="WhatsApp Desa Kalimanah"><i class="ph ph-whatsapp-logo" aria-hidden="true"></i></a>
        <a href="#" target="blank" aria-label="Instagram Desa Kalimanah"><i class="ph ph-instagram-logo" aria-hidden="true"></i></a>
        <a href="#" target="blank" aria-label="TikTok Desa Kalimanah"><i class="ph ph-tiktok-logo" aria-hidden="true"></i></a>
    </nav>
    {{-- Hak cipta di baris bawah (tahun otomatis) --}}
    <p class="footer-copy">&copy; {{ date('Y') }} Balai Desa Kalimanah</p>
</div>
