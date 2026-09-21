// JS halaman NOTIFIKASI warga - konfirmasi hapus semua. Jalan setelah HTML selesai dibaca.
document.addEventListener('DOMContentLoaded', () => {
  // Form bertanda data-konfirmasi: tahan kirim, tanya dulu, lanjut jika setuju
  document.querySelectorAll('form[data-konfirmasi]').forEach((form) => {
    form.addEventListener('submit', (e) => {
      if (!window.confirm(form.dataset.konfirmasi)) e.preventDefault();
    });
  });
});
