<?php

// Notifikasi aduan baru untuk admin

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AduanMasuk extends Notification
{
    use Queueable;

    // Aduan yang baru dikirim warga
    public function __construct(public $aduan) {}

    // Simpan ke database agar tampil di dashboard admin
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    // Isi notifikasi: judul + pelapor + tautan periksa
    public function toArray(object $notifiable): array
    {
        return [
            'judul' => 'Aduan baru "' . $this->aduan->judul . '" dari ' . ($this->aduan->user->name ?? 'warga') . '.',
            'url' => route('admin.aduan.show', $this->aduan->id),
        ];
    }
}
