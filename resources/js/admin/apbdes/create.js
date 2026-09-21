// JS halaman TAMBAH APBDES - validasi Indonesia + format rupiah bertitik. Jalan setelah HTML selesai dibaca.
document.addEventListener('DOMContentLoaded', () => {
  // Pesan wajib isi (ganti teks Inggris bawaan browser)
  const PESAN_WAJIB = {
    tahun: 'Silahkan isi tahun anggaran',
    bidang: 'Silahkan masukkan bidang kegiatan',
    uraian: 'Silahkan masukkan uraian pos',
    sumber_dana: 'Silahkan masukkan sumber dana',
    anggaran: 'Silahkan isi pagu anggaran',
  };
  document.querySelectorAll('.form-card input[required], .form-card select[required]').forEach((input) => {
    // Saat browser menolak isi: tampilkan pesan Indonesia
    input.addEventListener('invalid', () => {
      input.setCustomValidity(PESAN_WAJIB[input.name] ?? 'Silahkan isi kolom ini.');
    });
    // Bersihkan pesan saat user mengubah isi agar tidak menempel
    input.addEventListener('input', () => input.setCustomValidity(''));
  });

  // Format tampil 50000 -> 50.000 (titik ribuan Indonesia)
  const formatTitik = (nilai) => nilai.replace(/\D/g, '').replace(/^0+(?=\d)/, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
  const rupiah = document.querySelectorAll('input[data-rupiah]');
  // Format nilai awal dari old() agar langsung bertitik
  rupiah.forEach((input) => {
    if (input.value) input.value = formatTitik(input.value);
    // Ketik otomatis bertitik
    input.addEventListener('input', () => {
      input.value = formatTitik(input.value);
    });
  });
  // Sebelum kirim: kupas titik agar backend terima integer polos
  const form = document.querySelector('.form-card');
  if (form) {
    form.addEventListener('submit', () => {
      rupiah.forEach((input) => {
        input.value = input.value.replace(/\D/g, '');
      });
    });
  }
});
