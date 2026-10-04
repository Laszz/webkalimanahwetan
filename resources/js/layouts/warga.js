// JS kerangka WARGA - mode gelap/terang (tombol hanya ada di halaman tertentu) + smooth scroll.
import Lenis from 'lenis';
import 'lenis/dist/lenis.css';

// Smooth scroll Lenis untuk semua halaman layout warga (welcome + folder warga)
// autoRaf = loop bawaan; anchors = link #aduan/#berita tetap jalan;
// reduced-motion dihormati otomatis oleh Lenis (default respectReducedMotion)
try {
  new Lenis({ autoRaf: true, anchors: true });
} catch (e) {}

document.addEventListener('DOMContentLoaded', () => {
  const root = document.documentElement;

  // Terapkan simpanan bila ada (anti-kedip utama ditangani cuplikan di <head> layout)
  try {
    const simpan = localStorage.getItem('desa-theme');
    if (simpan === 'dark' || simpan === 'light') root.dataset.theme = simpan;
  } catch (e) {}

  // Tanpa tombol di halaman ini = tidak ada yang dikerjakan
  const btn = document.getElementById('theme-toggle');
  if (!btn) return;
  const ikon = btn.querySelector('.ph');

  // Samakan ikon + label dengan tema aktif
  const selaraskan = () => {
    const gelap = root.dataset.theme === 'dark';
    ikon.classList.toggle('ph-moon', !gelap);
    ikon.classList.toggle('ph-sun', gelap);
    btn.setAttribute('aria-label', gelap ? 'Ganti ke mode terang' : 'Ganti ke mode gelap');
  };
  selaraskan();

  // Klik = tukar tema + simpan pilihan
  btn.addEventListener('click', () => {
    root.dataset.theme = root.dataset.theme === 'dark' ? 'light' : 'dark';
    try {
      localStorage.setItem('desa-theme', root.dataset.theme);
    } catch (e) {}
    selaraskan();
  });
});
