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

  // Cek berkas saat dipilih: format dan ukuran sesuai aturan backend
  const BOLEH = ['image/jpeg', 'image/png', 'application/pdf'];
  const MAKS = 2 * 1024 * 1024;
  const popupFile = document.getElementById('popup-file');
  const popupPesan = document.getElementById('popup-file-pesan');
  // Tampilkan popup dengan pesan sesuai kesalahan
  const tolakBerkas = (input, pesan) => {
    input.value = '';
    if (popupPesan) popupPesan.textContent = pesan;
    if (popupFile) popupFile.removeAttribute('hidden');
  };
  document.querySelectorAll('input[data-cek-file]').forEach((input) => {
    input.addEventListener('change', () => {
      const berkas = input.files[0];
      if (!berkas) return;
      // Format di luar JPG/JPEG/PNG/PDF
      if (!BOLEH.includes(berkas.type)) {
        tolakBerkas(input, 'Format file tidak sesuai!');
        return;
      }
      // Lebih dari 2MB
      if (berkas.size > MAKS) {
        tolakBerkas(input, 'Ukuran file tidak sesuai, maksimal 2MB.');
      }
    });
  });

  // Tutup popup format salah
  if (popupFile) {
    popupFile.querySelector('[data-tutup]').addEventListener('click', () => popupFile.setAttribute('hidden', ''));
    popupFile.addEventListener('click', (e) => {
      if (e.target === popupFile) popupFile.setAttribute('hidden', '');
    });
  }
});
