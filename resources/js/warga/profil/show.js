// JS halaman PROFIL warga - intip password + bubble Indonesia + tutup popup. Jalan setelah HTML selesai dibaca.
document.addEventListener('DOMContentLoaded', () => {
  // Tombol mata: tampil/sembunyi isi kolom password sebelahnya
  document.querySelectorAll('.lihat-password').forEach((btn) => {
    btn.addEventListener('click', () => {
      const input = btn.closest('.field-password').querySelector('input');
      const ikon = btn.querySelector('.ph');
      const tampil = input.type === 'password';
      // Ganti tipe + ikon mata (terbuka/tertutup)
      input.type = tampil ? 'text' : 'password';
      ikon.classList.toggle('ph-eye', !tampil);
      ikon.classList.toggle('ph-eye-slash', tampil);
    });
  });

  // Pesan wajib isi (ganti teks Inggris bawaan browser)
  const PESAN_WAJIB = {
    current_password: 'Silahkan isi password lama',
    password: 'Silahkan isi password baru',
    password_confirmation: 'Silahkan konfirmasi password baru',
  };
  document.querySelectorAll('.form-card input[required]').forEach((input) => {
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
