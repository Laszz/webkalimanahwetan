// JS halaman UBAH SURVEI - bubble Indonesia + konfirmasi hapus pertanyaan. Jalan setelah HTML selesai dibaca.
document.addEventListener('DOMContentLoaded', () => {
  // Pesan wajib isi (ganti teks Inggris bawaan browser)
  const PESAN_WAJIB = { judul: 'Silahkan masukkan judul survei' };
  document.querySelectorAll('.form-card input[required], .form-card textarea[required]').forEach((input) => {
    // Saat browser menolak isi: tampilkan pesan Indonesia
    input.addEventListener('invalid', () => {
      input.setCustomValidity(PESAN_WAJIB[input.name] ?? 'Silahkan isi kolom ini.');
    });
    // Bersihkan pesan saat user mengubah isi agar tidak menempel
    input.addEventListener('input', () => input.setCustomValidity(''));
  });

  // Tiap form hapus pertanyaan: tahan kirim, tanya dulu, lanjut jika setuju
  document.querySelectorAll('form[data-konfirmasi]').forEach((form) => {
    form.addEventListener('submit', (e) => {
      if (!window.confirm(form.dataset.konfirmasi)) e.preventDefault();
    });
  });
});
