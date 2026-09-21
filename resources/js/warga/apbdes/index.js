// JS halaman APBDES warga - ganti tahun otomatis tampil. Jalan setelah HTML selesai dibaca.
document.addEventListener('DOMContentLoaded', () => {
  // Pilihan tahun bertanda data-otomatis: langsung kirim form saat diganti
  const pilih = document.querySelector('select[data-otomatis]');
  if (!pilih) return;
  pilih.addEventListener('change', () => pilih.form.submit());
});
