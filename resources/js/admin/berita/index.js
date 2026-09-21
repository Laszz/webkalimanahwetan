// JS halaman BERITA - konfirmasi hapus + tutup popup. Jalan setelah HTML selesai dibaca.
document.addEventListener('DOMContentLoaded', () => {
  // Tiap form bertanda data-konfirmasi: tahan kirim, tanya dulu, lanjut jika setuju
  document.querySelectorAll('form[data-konfirmasi]').forEach((form) => {
    form.addEventListener('submit', (e) => {
      if (!window.confirm(form.dataset.konfirmasi)) e.preventDefault();
    });
  });

  // Popup hasil aksi: tombol tutup + klik latar gelap
  const popup = document.getElementById('popup');
  if (!popup) return;
  popup.querySelector('[data-tutup]').addEventListener('click', () => popup.remove());
  popup.addEventListener('click', (e) => {
    if (e.target === popup) popup.remove();
  });
});
