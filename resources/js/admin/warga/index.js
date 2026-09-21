// JS halaman DATA WARGA - konfirmasi sebelum hapus biodata. Jalan setelah HTML selesai dibaca.
document.addEventListener('DOMContentLoaded', () => {
  // Tiap form bertanda data-konfirmasi: tahan kirim, tanya dulu, lanjut jika setuju
  document.querySelectorAll('form[data-konfirmasi]').forEach((form) => {
    form.addEventListener('submit', (e) => {
      if (!window.confirm(form.dataset.konfirmasi)) e.preventDefault();
    });
  });
});
