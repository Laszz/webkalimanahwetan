// JS halaman SURVEI warga - popup sudah mengisi + bubble Indonesia + kunci kirim. Jalan setelah HTML selesai dibaca.
document.addEventListener('DOMContentLoaded', () => {
  // Popup + tombol tutup; kalau tidak ada berhenti
  const popup = document.getElementById('popup');
  if (popup) {
    // Tiap tombol bertanda data-popup: tampilkan popup, jangan pindah halaman
    document.querySelectorAll('[data-popup]').forEach((btn) => {
      btn.addEventListener('click', () => popup.removeAttribute('hidden'));
    });

    // Tutup via tombol + klik latar gelap
    popup.querySelector('[data-tutup]').addEventListener('click', () => popup.setAttribute('hidden', ''));
    popup.addEventListener('click', (e) => {
      if (e.target === popup) popup.setAttribute('hidden', '');
    });
  }

  // Pesan wajib isi (ganti teks Inggris bawaan browser)
  document.querySelectorAll('.survei-grid [required]').forEach((input) => {
    input.addEventListener('invalid', () => {
      input.setCustomValidity('Silahkan jawab pertanyaan ini.');
    });
    // Bersihkan pesan saat user mengubah isi agar tidak menempel
    input.addEventListener('input', () => input.setCustomValidity(''));
    input.addEventListener('change', () => input.setCustomValidity(''));
  });

  // Kunci tombol kirim tiap form agar klik ganda/spam hanya masuk 1
  document.querySelectorAll('.survei-grid form').forEach((form) => {
    form.addEventListener('submit', () => {
      const tombol = form.querySelector('[type="submit"]');
      if (tombol && !tombol.disabled) {
        tombol.disabled = true;
        tombol.textContent = 'Mengirim...';
      }
    });
  });
});
