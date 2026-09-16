<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard warga (butuh login) - ringkasan + riwayat pengajuan milik sendiri
Route::get('/warga', function () {
    return view('warga.dashboard');
})->middleware(['auth'])->name('warga.dashboard');

// Dashboard admin (butuh login) - kelola pengajuan, warga, dan konten desa
Route::get('/admin', function () {
    return view('admin.dashboard');
})->middleware(['auth'])->name('admin.dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
