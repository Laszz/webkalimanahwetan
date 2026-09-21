// JS halaman SURVEI warga - popup sudah mengisi. Jalan setelah HTML selesai dibaca.
document.addEventListener('DOMContentLoaded', () => {
  // Popup + tombol tutup; kalau tidak ada berhenti
  const popup = document.getElementById('popup');
  if (!popup) return;

  // Tiap tombol bertanda data-popup: tampilkan popup, jangan pindah halaman
  document.querySelectorAll('[data-popup]').forEach((btn) => {
    btn.addEventListener('click', () => popup.removeAttribute('hidden'));
  });

  // Tutup via tombol + klik latar gelap
  popup.querySelector('[data-tutup]').addEventListener('click', () => popup.setAttribute('hidden', ''));
  popup.addEventListener('click', (e) => {
    if (e.target === popup) popup.setAttribute('hidden', '');
  });
});
