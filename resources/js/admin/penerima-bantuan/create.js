// JS halaman TAMBAH PENERIMA - titik ribuan otomatis di kolom nominal. Jalan setelah HTML selesai dibaca.
document.addEventListener('DOMContentLoaded', () => {
  // Kolom tampil (bertitik) dan kolom kirim (angka bersih untuk server)
  const tampil = document.getElementById('nominal-tampil');
  const kirim = document.getElementById('nominal');
  if (!tampil || !kirim) return;

  // Tulis ulang: tampil bertitik id-ID, kirim angka polos
  const tulis = () => {
    // Buang semua non-digit lalu format titik ribuan
    const bersih = tampil.value.replace(/\D/g, '').slice(0, 15);
    tampil.value = bersih ? Number(bersih).toLocaleString('id-ID') : '';
    kirim.value = bersih;
  };
  tampil.addEventListener('input', tulis);
  // Format sekali saat halaman dibuka (nilai old setelah validasi gagal)
  tulis();
});
