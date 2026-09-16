// JS halaman LOGIN - slider overlay + ikon mata password. Jalan setelah HTML selesai dibaca browser.
document.addEventListener('DOMContentLoaded', () => {
  // Ambil kartu slider; kalau tidak ada (bukan halaman auth) berhenti agar tidak error
  const container = document.getElementById('container');
  if (!container) return;
  // Paksa posisi panel ikut state dari server (data-active-form) - anti tampilan basi dari cache browser
  const applyState = () => container.classList.toggle('right-panel-active', container.dataset.activeForm === 'register');
  applyState();
  // pageshow = juga saat user tekan tombol back (browser bisa memulihkan DOM lama)
  window.addEventListener('pageshow', applyState);
  // Tandai HP (≤768px) agar pindah halaman lebih cepat (tanpa menunggu animasi overlay yg disembunyikan)
  const isMobile = window.matchMedia('(max-width: 768px)').matches;
  // Semua link pindah form (tombol overlay biru + link HP): animasi slide dulu, baru pindah halaman
  document.querySelectorAll('[data-show]').forEach((el) => {
    el.addEventListener('click', (e) => {
      // Tujuan link; abaikan jika kosong/#
      const target = el.getAttribute('href');
      if (!target || target === '#') return;
      // Tahan pindah halaman bawaan browser agar sempat animasi
      e.preventDefault();
      // Aktifkan keyframe kemunculan form daftar khusus untuk klik ini
      container.classList.add('slide');
      // Tentukan panel tujuan: register = tambah class, login = hapus class
      container.classList.toggle('right-panel-active', el.dataset.show === 'register');
      // Pindah halaman setelah slide selesai (desktop 400ms ≥ animasi 350ms; HP 150ms)
      setTimeout(() => { window.location.href = target; }, isMobile ? 150 : 400);
    });
  });

  // Ikon mata intip password: dipasang otomatis ke tiap input password (blade tidak perlu diubah)
  // Ikon Phosphor mata terbuka (tampil saat password disembunyikan)
  const EYE_OPEN = '<i class="ph ph-eye" aria-hidden="true"></i>';
  // Ikon Phosphor mata tercoret (tampil saat password sedang diintip)
  const EYE_CLOSED = '<i class="ph ph-eye-slash" aria-hidden="true" style="display:none"></i>';
  document.querySelectorAll('.auth-wrap input[type="password"]').forEach((input) => {
    // Bungkus input dengan div relatif agar tombol mata bisa diposisikan di dalamnya
    const wrap = document.createElement('div');
    wrap.className = 'pw-wrap';
    input.after(wrap);
    wrap.appendChild(input);
    // Buat tombol mata (type=button agar tidak ikut submit form)
    const btn = document.createElement('button');
    btn.type = 'button';
    btn.className = 'pw-toggle';
    btn.setAttribute('aria-label', 'Tampilkan password');
    btn.innerHTML = EYE_OPEN + EYE_CLOSED;
    // Klik mata = tukar tipe input + tukar ikon yg tampil
    btn.addEventListener('click', () => {
      const show = input.type === 'password';
      input.type = show ? 'text' : 'password';
      btn.querySelectorAll('.ph')[0].style.display = show ? 'none' : '';
      btn.querySelectorAll('.ph')[1].style.display = show ? '' : 'none';
      btn.setAttribute('aria-label', show ? 'Sembunyikan password' : 'Tampilkan password');
    });
    wrap.appendChild(btn);
  });
});
