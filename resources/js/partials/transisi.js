// Transisi pindah halaman via GSAP (layout warga: welcome + folder warga).
// Prinsip: hanya fade-OUT (halaman sudah tampil penuh saat dipudarkan = mulus).
// Fade-IN sengaja tidak dipakai: di MPA, konten sempat terlihat sekilas sebelum JS
// jalan, lalu dipaksa transparan + dimunculkan lagi = kedip/glitch yang kamu rasakan.
// Tanpa-JS = pindah biasa. Hormati gerak-minim.
import { gsap } from 'gsap';

// Nyalakan transisi; diam total jika user pilih gerak-minim
export function initTransisi() {
  // Kembali via tombol back browser: cache halaman menyimpan opacity 0
  // dari fade-out → bersihkan agar konten tidak blank hitam
  window.addEventListener('pageshow', (e) => {
    if (!e.persisted) return;
    const utama = document.querySelector('main.site-main');
    if (utama) gsap.set(utama, { clearProps: 'opacity' });
  });

  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

  // Keluar: cegat klik link internal, pudarkan dulu baru pindah
  document.addEventListener('click', (e) => {
    const tautan = e.target.closest('a[href]');
    if (!tautan) return;
    // Lewati: tab baru, unduhan, jangkar halaman, link luar, klik kanan
    if (tautan.target === '_blank' || tautan.hasAttribute('download') || e.metaKey || e.ctrlKey || e.shiftKey || e.button !== 0) return;
    const url = new URL(tautan.href, location.origin);
    if (url.origin !== location.origin) return;
    if (url.pathname === location.pathname && url.hash) return;

    // Halaman + query yang sama persis (mis. klik Beranda saat sudah di beranda) = meluncur ke atas
    // Query beda (filter kategori, pagination, cari) = tetap pindah normal di bawah
    if (url.pathname === location.pathname && url.search === location.search && !url.hash) {
      e.preventDefault();
      if (window.__desaLenis) {
        window.__desaLenis.scrollTo(0, { duration: 1.2 });
      } else {
        window.scrollTo({ top: 0, behavior: 'smooth' });
      }
      return;
    }

    e.preventDefault();
    const utama = document.querySelector('main.site-main') || document.body;
    gsap.to(utama, {
      opacity: 0, duration: 0.25, ease: 'power2.in',
      onComplete: () => { location.href = tautan.href; },
    });
  });
}
