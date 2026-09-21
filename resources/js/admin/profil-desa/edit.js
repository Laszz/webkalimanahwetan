// JS halaman PROFIL DESA - bubble Indonesia + tutup popup. Jalan setelah HTML selesai dibaca.
document.addEventListener('DOMContentLoaded', () => {
  // Pesan wajib isi (ganti teks Inggris bawaan browser)
  const PESAN_WAJIB = { nama_desa: 'Silahkan masukkan nama desa', visi: 'Silahkan tulis visi desa', misi: 'Silahkan tulis misi desa' };
  document.querySelectorAll('.form-card input[required], .form-card textarea[required]').forEach((input) => {
    // Saat browser menolak isi: tampilkan pesan Indonesia
    input.addEventListener('invalid', () => {
      input.setCustomValidity(PESAN_WAJIB[input.name] ?? 'Silahkan isi kolom ini.');
    });
    // Bersihkan pesan saat user mengubah isi agar tidak menempel
    input.addEventListener('input', () => input.setCustomValidity(''));
  });

  // Popup hasil aksi: tombol tutup + klik latar gelap
  const popup = document.getElementById('popup');
  if (!popup) return;
  popup.querySelector('[data-tutup]').addEventListener('click', () => popup.remove());
  popup.addEventListener('click', (e) => {
    if (e.target === popup) popup.remove();
  });
});
