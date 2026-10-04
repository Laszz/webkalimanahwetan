// Helper animasi scroll-reveal bersama (welcome + dashboard warga) via Motion.
// Pola: seksi fade-naik saat masuk viewport, kartu mini stagger, hero entrance.
// Tanpa-JS = konten tampil normal (state awal diatur lewat JS, bukan CSS).
import { animate, inView, stagger } from 'motion';

// Nyalakan semua pola; diam total jika user pilih gerak-minim
export function initReveals() {
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

  // 3. Entrance hero: kicker, judul, deskripsi muncul bertahap
  animate(
    '.hero .hero-kicker, .hero h1, .hero .hero-deskripsi',
    { opacity: [0, 1], y: [16, 0] },
    { duration: 0.7, delay: stagger(0.12), easing: 'ease-out' }
  );

  // 1. Tiap seksi fade + naik 24px sekali saat masuk viewport
  inView('.sambutan, .berita, .agenda, .aduan, .peta', (el) => {
    animate(
      el,
      { opacity: [0, 1], y: [24, 0] },
      { duration: 0.7, easing: 'ease-out' }
    );

    // 2. Kartu mini di seksi ini muncul berurutan 0.08 detik
    const minis = el.querySelectorAll('.unggulan-list li');
    if (minis.length) {
      animate(minis, { opacity: [0, 1], y: [16, 0] }, { duration: 0.5, delay: stagger(0.08), easing: 'ease-out' });
    }
  }, { amount: 0.15 });
}
