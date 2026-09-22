// JS halaman AJUKAN SURAT - bubble validasi browser berbahasa Indonesia. Jalan setelah HTML selesai dibaca.
document.addEventListener('DOMContentLoaded', () => {
  // Semua isian wajib di form: tampilkan pesan Indonesia saat browser menolak
  document.querySelectorAll('.form-card [required]').forEach((input) => {
    input.addEventListener('invalid', () => {
      input.setCustomValidity('Silahkan lengkapi isian ini.');
    });
    // Bersihkan pesan saat user mengubah isi agar tidak menempel
    input.addEventListener('input', () => input.setCustomValidity(''));
    input.addEventListener('change', () => input.setCustomValidity(''));
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
