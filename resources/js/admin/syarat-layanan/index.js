// JS halaman SYARAT LAYANAN - konfirmasi hapus + tutup popup + bubble Indonesia. Jalan setelah HTML selesai dibaca.
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

  // Pesan wajib isi (ganti teks Inggris bawaan browser)
  const PESAN_WAJIB = { nama: 'Silahkan masukkan nama syarat' };
  document.querySelectorAll('.form-card input[required], .form-card select[required]').forEach((input) => {
    // Saat browser menolak isi: tampilkan pesan Indonesia
    input.addEventListener('invalid', () => {
      input.setCustomValidity(PESAN_WAJIB[input.name] ?? 'Silahkan isi kolom ini.');
    });
    // Bersihkan pesan saat user mengubah isi agar tidak menempel
    input.addEventListener('input', () => input.setCustomValidity(''));
    input.addEventListener('change', () => input.setCustomValidity(''));
  });
});
