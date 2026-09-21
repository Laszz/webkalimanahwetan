// JS halaman ISI BIODATA warga - bubble validasi browser berbahasa Indonesia. Jalan setelah HTML selesai dibaca.
document.addEventListener('DOMContentLoaded', () => {
  // Pesan wajib isi per kolom (ganti teks Inggris bawaan browser)
  const PESAN_WAJIB = {
    nik: 'Silahkan masukkan NIK',
    no_kk: 'Silahkan masukkan No. KK',
    nama: 'Silahkan masukkan nama anda',
    tempat_lahir: 'Silahkan masukkan tempat lahir',
    tanggal_lahir: 'Silahkan isi tanggal lahir',
    jenis_kelamin: 'Silahkan pilih jenis kelamin',
    alamat: 'Silahkan masukkan alamat',
    rt: 'Silahkan masukkan RT',
    rw: 'Silahkan masukkan RW',
    agama: 'Silahkan pilih agama',
    status_kawin: 'Silahkan pilih status pernikahan',
  };
  document.querySelectorAll('.profil input[required], .profil select[required]').forEach((input) => {
    // Saat browser menolak isi: tampilkan pesan Indonesia
    input.addEventListener('invalid', () => {
      input.setCustomValidity(PESAN_WAJIB[input.name] ?? 'Silahkan isi kolom ini.');
    });
    // Bersihkan pesan saat user mengubah isi agar tidak menempel
    input.addEventListener('input', () => input.setCustomValidity(''));
    input.addEventListener('change', () => input.setCustomValidity(''));
  });
});
