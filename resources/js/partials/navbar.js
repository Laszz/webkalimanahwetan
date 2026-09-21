// JS NAVBAR publik — menu hamburger HP + link aktif. Jalan setelah HTML selesai dibaca.
document.addEventListener('DOMContentLoaded', () => {
  // Ambil navbar; kalau halaman tidak pakai navbar berhenti agar tidak error
  const navbar = document.querySelector('.navbar');
  if (!navbar) return;

  // Tombol hamburger: buka/tutup menu di HP
  const toggle = navbar.querySelector('.nav-toggle');
  if (toggle) {
    toggle.addEventListener('click', () => {
      // Buka/tutup daftar menu + update status untuk screen reader
      const open = navbar.classList.toggle('menu-open');
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
    // Klik salah satu menu di HP = otomatis tutup menu
    navbar.querySelectorAll('.nav-links a').forEach((link) => {
      link.addEventListener('click', () => {
        navbar.classList.remove('menu-open');
        toggle.setAttribute('aria-expanded', 'false');
      });
    });
  }

  // Tombol teks tiap dropdown layanan: buka/tutup submenu
  navbar.querySelectorAll('.nav-drop-btn').forEach((btn) => {
    btn.addEventListener('click', (e) => {
      // Jangan ikut menutup menu HP saat toggle diklik
      e.stopPropagation();
      const item = btn.closest('.nav-drop');
      // Tutup dropdown lain yang terbuka
      navbar.querySelectorAll('.nav-drop.open').forEach((lain) => {
        if (lain !== item) {
          lain.classList.remove('open');
          lain.querySelector('.nav-drop-btn').setAttribute('aria-expanded', 'false');
        }
      });
      // Buka/tutup dropdown ini + update status untuk screen reader
      const open = item.classList.toggle('open');
      btn.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  });

  // Klik di luar dropdown = tutup semua
  document.addEventListener('click', (e) => {
    navbar.querySelectorAll('.nav-drop.open').forEach((item) => {
      item.classList.remove('open');
      item.querySelector('.nav-drop-btn').setAttribute('aria-expanded', 'false');
    });
    // Kotak notifikasi (details bawaan browser) ikut tertutup
    const belWrap = navbar.querySelector('.nav-bel-wrap');
    if (belWrap && belWrap.hasAttribute('open') && !belWrap.contains(e.target)) {
      belWrap.removeAttribute('open');
    }
  });

  // Tandai link menu yg sesuai halaman aktif (agar terlihat sedang dibuka)
  const currentPath = window.location.pathname;
  navbar.querySelectorAll('.nav-links a').forEach((link) => {
    if (link.getAttribute('href') === currentPath) link.classList.add('active');
  });
});
