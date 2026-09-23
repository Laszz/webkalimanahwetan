// JS halaman LUPA PASSWORD - bubble validasi Indonesia. Jalan setelah HTML selesai dibaca.
document.addEventListener('DOMContentLoaded', () => {
  // Kolom email wajib: ganti bubble Inggris bawaan browser
  const email = document.querySelector('input[name="email"][required]');
  if (!email) return;
  email.addEventListener('invalid', () => {
    email.setCustomValidity('Silahkan masukkan email anda.');
  });
  // Bersihkan pesan saat user mengubah isi agar tidak menempel
  email.addEventListener('input', () => email.setCustomValidity(''));
});
