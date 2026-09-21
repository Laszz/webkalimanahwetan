// JS SIDEBAR admin — laci sidebar HP + link aktif. Jalan setelah HTML selesai dibaca.
document.addEventListener('DOMContentLoaded', () => {
  // Ambil kerangka admin; kalau bukan halaman admin berhenti agar tidak error
  const shell = document.querySelector('.admin-shell');
  if (!shell) return;

  // Tombol hamburger: buka/tutup laci sidebar di HP
  const toggle = shell.querySelector('.sidebar-toggle');
  if (toggle) {
    toggle.addEventListener('click', () => {
      // Buka/tutup laci + update status untuk screen reader
      const open = shell.classList.toggle('sidebar-open');
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
    // Klik salah satu menu sidebar di HP = otomatis tutup laci
    shell.querySelectorAll('.sidebar-menu a').forEach((link) => {
      link.addEventListener('click', () => {
        shell.classList.remove('sidebar-open');
        toggle.setAttribute('aria-expanded', 'false');
      });
    });
  }

  // Klik latar gelap = tutup laci sidebar
  const backdrop = shell.querySelector('.sidebar-backdrop');
  if (backdrop) {
    backdrop.addEventListener('click', () => {
      shell.classList.remove('sidebar-open');
      if (toggle) toggle.setAttribute('aria-expanded', 'false');
    });
  }

  // Tandai link sidebar yg sesuai halaman aktif (agar terlihat sedang dibuka)
  const currentPath = window.location.pathname;
  shell.querySelectorAll('.sidebar-menu a').forEach((link) => {
    if (link.getAttribute('href') !== currentPath) return;
    link.classList.add('active');
    // Buka otomatis dropdown yg memuat halaman aktif
    const grup = link.closest('details');
    if (grup) grup.open = true;
  });
});
