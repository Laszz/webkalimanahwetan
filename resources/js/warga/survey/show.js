// JS halaman ISI SURVEI - bubble validasi browser berbahasa Indonesia. Jalan setelah HTML selesai dibaca.
document.addEventListener('DOMContentLoaded', () => {
  // Semua isian wajib di form: tampilkan pesan Indonesia saat browser menolak
  document.querySelectorAll('.survei-isi [required]').forEach((input) => {
    input.addEventListener('invalid', () => {
      input.setCustomValidity('Silahkan jawab pertanyaan ini.');
    });
    // Bersihkan pesan saat user mengubah isi agar tidak menempel
    input.addEventListener('input', () => input.setCustomValidity(''));
    input.addEventListener('change', () => input.setCustomValidity(''));
  });
});
