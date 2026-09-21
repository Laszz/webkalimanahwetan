// JS dashboard WARGA - tutup popup info. Jalan setelah HTML selesai dibaca.
document.addEventListener('DOMContentLoaded', () => {
  // Popup info (mis. pengalihan survei lunas): tombol tutup + klik latar gelap
  const popup = document.getElementById('popup');
  if (!popup) return;
  popup.querySelector('[data-tutup]').addEventListener('click', () => popup.remove());
  popup.addEventListener('click', (e) => {
    if (e.target === popup) popup.remove();
  });
});
