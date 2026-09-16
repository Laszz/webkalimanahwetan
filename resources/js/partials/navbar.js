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

  // Tandai link menu yg sesuai halaman aktif (agar terlihat sedang dibuka)
  const currentPath = window.location.pathname;
  navbar.querySelectorAll('.nav-links a').forEach((link) => {
    if (link.getAttribute('href') === currentPath) link.classList.add('active');
  });
});
