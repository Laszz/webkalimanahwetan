// JS halaman TAMBAH AGENDA - bubble validasi browser berbahasa Indonesia. Jalan setelah HTML selesai dibaca.
document.addEventListener('DOMContentLoaded', () => {
  // Pesan wajib isi (ganti teks Inggris bawaan browser)
  const PESAN_WAJIB = { judul: 'Silahkan masukkan judul kegiatan', tempat: 'Silahkan masukkan tempat', mulai: 'Silahkan isi waktu mulai' };
  document.querySelectorAll('.form-card input[required], .form-card textarea[required]').forEach((input) => {
    // Saat browser menolak isi: tampilkan pesan Indonesia
    input.addEventListener('invalid', () => {
      input.setCustomValidity(PESAN_WAJIB[input.name] ?? 'Silahkan isi kolom ini.');
    });
    // Bersihkan pesan saat user mengubah isi agar tidak menempel
    input.addEventListener('input', () => input.setCustomValidity(''));
  });
});
