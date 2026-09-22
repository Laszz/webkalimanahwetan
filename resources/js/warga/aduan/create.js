// JS halaman BUAT ADUAN - bubble validasi browser berbahasa Indonesia. Jalan setelah HTML selesai dibaca.
document.addEventListener('DOMContentLoaded', () => {
  // Pesan wajib isi (ganti teks Inggris bawaan browser)
  const PESAN_WAJIB = { judul: 'Silahkan masukkan judul aduan', isi: 'Silahkan ceritakan aduan anda' };
  document.querySelectorAll('.form-card input[required], .form-card textarea[required]').forEach((input) => {
    // Saat browser menolak isi: tampilkan pesan Indonesia
    input.addEventListener('invalid', () => {
      input.setCustomValidity(PESAN_WAJIB[input.name] ?? 'Silahkan isi kolom ini.');
    });
    // Bersihkan pesan saat user mengubah isi agar tidak menempel
    input.addEventListener('input', () => input.setCustomValidity(''));
  });

  // Kunci tombol kirim saat form dikirim agar klik ganda/spam hanya masuk 1
  const form = document.querySelector('.form-card');
  if (form) {
    form.addEventListener('submit', () => {
      const tombol = form.querySelector('[type="submit"]');
      if (tombol && !tombol.disabled) {
        tombol.disabled = true;
        tombol.textContent = 'Mengirim...';
      }
    });
  }
});
