<?php

// Notifikasi akun warga baru mendaftar untuk admin

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AkunBaru extends Notification
{
    use Queueable;

    // Akun warga yang baru mendaftar
    public function __construct(public $user) {}

    // Simpan ke database agar tampil di dashboard admin
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    // Isi notifikasi: nama pendaftar + tautan verifikasi
    public function toArray(object $notifiable): array
    {
        return [
            'judul' => 'Akun baru "' . $this->user->name . '" menunggu verifikasi.',
            'url' => route('admin.pengguna.index', ['status' => 'menunggu']),
        ];
    }
}
