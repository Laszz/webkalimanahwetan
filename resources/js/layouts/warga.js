// JS kerangka WARGA - mode gelap/terang (tombol hanya ada di halaman tertentu) + smooth scroll + transisi halaman.
import Lenis from 'lenis';
import 'lenis/dist/lenis.css';
import { initTransisi } from '../partials/transisi.js';

// Smooth scroll Lenis untuk semua halaman layout warga (welcome + folder warga)
// autoRaf = loop bawaan; anchors = link #aduan/#berita tetap jalan;
// allowNestedScroll = scroller horizontal (pil filter, kartu geser) tetap native;
// reduced-motion dihormati otomatis oleh Lenis (default respectReducedMotion)
try {
  // Singleton: cegah instans ganda (mis. hot-reload dev) yang bikin scroll ngebut
  if (window.__desaLenis) window.__desaLenis.destroy();
  window.__desaLenis = new Lenis({ autoRaf: true, anchors: true, allowNestedScroll: true, syncTouch: true });
} catch (e) {}

// Klik peta = aktifkan interaksi iframe (default nonaktif agar scroll halaman tetap mulus)
document.addEventListener('click', (e) => {
  const bingkai = e.target.closest('.peta-wrap');
  if (bingkai && !bingkai.classList.contains('peta-aktif')) {
    bingkai.classList.add('peta-aktif');
  }
});

document.addEventListener('DOMContentLoaded', () => {
  initTransisi();

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

  // Klik = tukar tema + simpan pilihan (transisi mulus bila browser mendukung)
  btn.addEventListener('click', () => {
    const ganti = () => {
      root.dataset.theme = root.dataset.theme === 'dark' ? 'light' : 'dark';
      try {
        localStorage.setItem('desa-theme', root.dataset.theme);
      } catch (e) {}
      selaraskan();
    };
    // View Transitions API: cross-fade 60fps; fallback = transisi CSS sementara
    if (document.startViewTransition) {
      document.startViewTransition(ganti);
    } else {
      root.classList.add('tema-animasi');
      ganti();
      setTimeout(() => root.classList.remove('tema-animasi'), 450);
    }
  });
});
