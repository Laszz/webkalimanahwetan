<?php

use App\Http\Controllers\Admin\AduanController as AdminAduanController;
use App\Http\Controllers\Admin\AgendaController as AdminAgendaController;
use App\Http\Controllers\Admin\BelanjaController as AdminBelanjaController;
use App\Http\Controllers\Admin\DanaController as AdminDanaController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\NotifikasiController as AdminNotifikasiController;
use App\Http\Controllers\Admin\GaleriController as AdminGaleriController;
use App\Http\Controllers\Admin\JenisBantuanController;
use App\Http\Controllers\Admin\LayananController as AdminLayananController;
use App\Http\Controllers\Admin\PenerimaBantuanController as AdminPenerimaController;
use App\Http\Controllers\Admin\PengajuanController as AdminPengajuanController;
use App\Http\Controllers\Admin\PerangkatDesaController as AdminPerangkatController;
use App\Http\Controllers\Admin\PertanyaanController;
use App\Http\Controllers\Admin\ProfilDesaController as AdminProfilDesaController;
use App\Http\Controllers\Admin\SurveyController as AdminSurveyController;
use App\Http\Controllers\Admin\SyaratController;
use App\Http\Controllers\Admin\TanggapanController;
use App\Http\Controllers\Admin\TemplateController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\WargaController as AdminWargaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Warga\AduanController as WargaAduanController;
use App\Http\Controllers\Warga\AgendaController as WargaAgendaController;
use App\Http\Controllers\Warga\ApbdesController as WargaApbdesController;
use App\Http\Controllers\Warga\BeritaController as WargaBeritaController;
use App\Http\Controllers\Warga\DashboardController as WargaDashboardController;
use App\Http\Controllers\Warga\GaleriController as WargaGaleriController;
use App\Http\Controllers\Warga\LayananController as WargaLayananController;
use App\Http\Controllers\Warga\NotifikasiController as WargaNotifikasiController;
use App\Http\Controllers\Warga\PenerimaBantuanController as WargaBantuanController;
use App\Http\Controllers\Warga\PengajuanController as WargaPengajuanController;
use App\Http\Controllers\Warga\PerangkatDesaController as WargaPerangkatController;
use App\Http\Controllers\Warga\ProfilDesaController as WargaProfilDesaController;
use App\Http\Controllers\Warga\SurveyController as WargaSurveyController;
use App\Http\Controllers\Warga\WargaController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

// Halaman depan publik
Route::get('/', [WelcomeController::class, 'index']);

// Halaman publik warga (tanpa login, tanpa awalan /warga) - kecuali daftar layanan, buat aduan, dan survei
// Nama rute tetap warga.* agar blade tidak berubah
Route::name('warga.')->group(function () {
    // Profil desa + perangkat desa
    Route::get('/profil-desa', [WargaProfilDesaController::class, 'index'])->name('profil-desa.index');
    Route::get('/perangkat-desa', [WargaPerangkatController::class, 'index'])->name('perangkat-desa.index');

    // Berita desa
    Route::get('/berita', [WargaBeritaController::class, 'index'])->name('berita.index');
    Route::get('/berita/{slug}', [WargaBeritaController::class, 'show'])->name('berita.show');

    // Galeri foto
    Route::get('/galeri', [WargaGaleriController::class, 'index'])->name('galeri.index');
    Route::get('/galeri/{galeri}', [WargaGaleriController::class, 'show'])->name('galeri.show');

    // Transparansi APBDes
    Route::get('/apbdes', [WargaApbdesController::class, 'index'])->name('apbdes.index');

    // Agenda kegiatan
    Route::get('/agenda', [WargaAgendaController::class, 'index'])->name('agenda.index');

    // Bantuan sosial
    Route::get('/bantuan', [WargaBantuanController::class, 'index'])->name('penerimabantuan.index');
    Route::get('/bantuan/{bantuan}', [WargaBantuanController::class, 'show'])->name('penerimabantuan.show');
    // Detail milik sendiri: wajib login (tamu dilempar ke login, bukan pemilik dapat 403)
    Route::get('/bantuan/terima/{penerima}', [WargaBantuanController::class, 'detail'])->middleware('auth')->name('penerimabantuan.detail');

    // Aduan warga (daftar + detail publik; buat milik sendiri tetap wajib login di bawah)
    Route::get('/aduan', [WargaAduanController::class, 'index'])->name('aduan.index');
    Route::get('/aduan/{aduan}', [WargaAduanController::class, 'show'])->name('aduan.show');
});

// Dashboard bawaan Breeze (butuh login + verifikasi email)
// Dashboard bawaan Breeze dialihkan sesuai peran (view-nya sudah tidak dipakai)
Route::get('/dashboard', function () {
    return redirect()->route(auth()->user()->isAdmin() ? 'admin.dashboard' : 'warga.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profil akun sendiri (butuh login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============================================================
// WARGA - semua di bawah /warga, wajib login
// ============================================================
Route::middleware(['auth'])->prefix('warga')->name('warga.')->group(function () {
    // Dashboard warga
    Route::get('/', [WargaDashboardController::class, 'index'])->name('dashboard');

    // Profil/biodata sendiri
    Route::get('/profil', [WargaController::class, 'show'])->name('profil.show');
    Route::get('/profil/buat', [WargaController::class, 'create'])->name('profil.create');
    Route::post('/profil', [WargaController::class, 'store'])->name('profil.store');
    Route::get('/profil/ubah', [WargaController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [WargaController::class, 'update'])->name('profil.update');

    // Aduan warga (buat + simpan milik sendiri, wajib login)
    Route::get('/aduan/buat', [WargaAduanController::class, 'create'])->name('aduan.create');
    // Tahan spam klik ganda: maks 5 kiriman per menit
    Route::post('/aduan', [WargaAduanController::class, 'store'])->middleware('throttle:5,1')->name('aduan.store');

    // Katalog layanan
    Route::get('/layanan', [WargaLayananController::class, 'index'])->name('layanan.index');
    Route::get('/layanan/{layanan}', [WargaLayananController::class, 'show'])->name('layanan.show');

    // Pengajuan surat
    Route::get('/pengajuan', [WargaPengajuanController::class, 'index'])->name('pengajuan.index');
    Route::get('/pengajuan/buat', [WargaPengajuanController::class, 'create'])->name('pengajuan.create');
    // Tahan spam klik ganda: maks 5 kiriman per menit
    Route::post('/pengajuan', [WargaPengajuanController::class, 'store'])->middleware('throttle:5,1')->name('pengajuan.store');
    Route::get('/pengajuan/{pengajuan}/unduh', [WargaPengajuanController::class, 'unduh'])->name('pengajuan.unduh');

    // Notifikasi
    Route::get('/notifikasi', [WargaNotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::get('/notifikasi/{id}', [WargaNotifikasiController::class, 'show'])->name('notifikasi.show');
    Route::put('/notifikasi/{id}', [WargaNotifikasiController::class, 'update'])->name('notifikasi.update');
    Route::delete('/notifikasi', [WargaNotifikasiController::class, 'destroyAll'])->name('notifikasi.destroyAll');
    Route::delete('/notifikasi/{id}', [WargaNotifikasiController::class, 'destroy'])->name('notifikasi.destroy');

    // Survei
    Route::get('/survey', [WargaSurveyController::class, 'index'])->name('survey.index');
    Route::get('/survey/{survey}', [WargaSurveyController::class, 'show'])->name('survey.show');
    // Tahan spam klik ganda: maks 5 kiriman per menit
    Route::post('/survey/{survey}', [WargaSurveyController::class, 'store'])->middleware('throttle:5,1')->name('survey.store');
});

// ============================================================
// ADMIN - semua di bawah /admin, wajib login + peran admin
// ============================================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard statistik
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Buka notifikasi (tandai dibaca + teruskan)
    Route::get('/notifikasi/{id}', [AdminNotifikasiController::class, 'show'])->name('notifikasi.show');

    // Verifikasi akun warga
    Route::get('/pengguna', [AdminUserController::class, 'index'])->name('pengguna.index');
    Route::put('/pengguna/{user}', [AdminUserController::class, 'update'])->name('pengguna.update');
    Route::delete('/pengguna/{user}', [AdminUserController::class, 'destroy'])->name('pengguna.destroy');

    // Data warga
    Route::get('/warga', [AdminWargaController::class, 'index'])->name('warga.index');
    Route::get('/warga/{warga}', [AdminWargaController::class, 'show'])->name('warga.show');
    Route::delete('/warga/{warga}', [AdminWargaController::class, 'destroy'])->name('warga.destroy');

    // Aduan masuk
    Route::get('/aduan', [AdminAduanController::class, 'index'])->name('aduan.index');
    Route::get('/aduan/{aduan}', [AdminAduanController::class, 'show'])->name('aduan.show');
    Route::get('/aduan/{aduan}/edit', [AdminAduanController::class, 'edit'])->name('aduan.edit');
    Route::put('/aduan/{aduan}', [AdminAduanController::class, 'update'])->name('aduan.update');

    // Tanggapan aduan
    Route::post('/aduan/{aduan}/tanggapan', [TanggapanController::class, 'store'])->name('tanggapan.store');
    Route::put('/tanggapan/{tanggapan}', [TanggapanController::class, 'update'])->name('tanggapan.update');
    Route::delete('/tanggapan/{tanggapan}', [TanggapanController::class, 'destroy'])->name('tanggapan.destroy');

    // Berita (nama parameter disamakan dengan variabel controller)
    Route::resource('/berita', AdminBeritaController::class)->names('berita')->parameters(['berita' => 'berita']);

    // Galeri
    Route::resource('/galeri', AdminGaleriController::class)->names('galeri');

    // Layanan dan syarat
    Route::resource('/layanan', AdminLayananController::class)->names('layanan');

    // Syarat per layanan (?layanan=id)
    Route::get('/syarat-layanan', [SyaratController::class, 'index'])->name('syarat-layanan.index');
    Route::post('/syarat-layanan', [SyaratController::class, 'store'])->name('syarat-layanan.store');
    Route::delete('/syarat-layanan/{syarat}', [SyaratController::class, 'destroy'])->name('syarat-layanan.destroy');

    // Verifikasi pengajuan
    Route::get('/pengajuan', [AdminPengajuanController::class, 'index'])->name('pengajuan.index');
    Route::get('/pengajuan/{pengajuan}', [AdminPengajuanController::class, 'show'])->name('pengajuan.show');
    Route::get('/pengajuan/{pengajuan}/edit', [AdminPengajuanController::class, 'edit'])->name('pengajuan.edit');
    Route::put('/pengajuan/{pengajuan}', [AdminPengajuanController::class, 'update'])->name('pengajuan.update');
    Route::delete('/pengajuan/{pengajuan}', [AdminPengajuanController::class, 'destroy'])->name('pengajuan.destroy');

    // Agenda
    Route::resource('/agenda', AdminAgendaController::class)->names('agenda');

    // Dana APBDes (tanpa show, langsung ubah dari daftar)
    Route::resource('/dana', AdminDanaController::class)->names('dana')->except('show');

    // Belanja APBDes (tanpa show, langsung ubah dari daftar)
    Route::resource('/belanja', AdminBelanjaController::class)->names('belanja')->except('show');

    // Jenis bantuan
    Route::resource('/jenis-bantuan', JenisBantuanController::class)->names('jenis-bantuan');

    // Penerima bantuan
    Route::get('/penerima-bantuan', [AdminPenerimaController::class, 'index'])->name('penerima-bantuan.index');
    Route::get('/penerima-bantuan/buat', [AdminPenerimaController::class, 'create'])->name('penerima-bantuan.create');
    Route::post('/penerima-bantuan', [AdminPenerimaController::class, 'store'])->name('penerima-bantuan.store');
    Route::delete('/penerima-bantuan/{penerimaBantuan}', [AdminPenerimaController::class, 'destroy'])->name('penerima-bantuan.destroy');

    // Survei dan pertanyaan (nama parameter disamakan dengan variabel controller)
    Route::resource('/survey', AdminSurveyController::class)->names('survey')->parameters(['survey' => 'survey']);
    Route::post('/survey/{survey}/pertanyaan', [PertanyaanController::class, 'store'])->name('pertanyaan.store');
    Route::put('/pertanyaan/{pertanyaan}', [PertanyaanController::class, 'update'])->name('pertanyaan.update');
    Route::delete('/pertanyaan/{pertanyaan}', [PertanyaanController::class, 'destroy'])->name('pertanyaan.destroy');
    Route::delete('/jawaban/{jawaban}', [PertanyaanController::class, 'destroyJawaban'])->name('jawaban.destroy');

    // Template hasil layanan
    Route::get('/template', [TemplateController::class, 'index'])->name('template.index');
    Route::get('/template/buat', [TemplateController::class, 'create'])->name('template.create');
    Route::post('/template', [TemplateController::class, 'store'])->name('template.store');
    Route::get('/template/{template}/ubah', [TemplateController::class, 'edit'])->name('template.edit');
    Route::put('/template/{template}', [TemplateController::class, 'update'])->name('template.update');
    Route::delete('/template/{template}', [TemplateController::class, 'destroy'])->name('template.destroy');

    // Perangkat desa (nama parameter disamakan dengan variabel controller)
    Route::resource('/perangkat-desa', AdminPerangkatController::class)->names('perangkat-desa')->parameters(['perangkat-desa' => 'perangkat']);

    // Profil desa (satu baris, tanpa id)
    Route::get('/profil-desa/ubah', [AdminProfilDesaController::class, 'edit'])->name('profil-desa.edit');
    Route::put('/profil-desa', [AdminProfilDesaController::class, 'update'])->name('profil-desa.update');
});

require __DIR__.'/auth.php';
