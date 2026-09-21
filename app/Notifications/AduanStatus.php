<?php

// Notifikasi perubahan status aduan untuk pelapor

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AduanStatus extends Notification
{
    use Queueable;

    // Aduan yang statusnya diubah admin (sudah berisi status baru)
    public function __construct(public $aduan) {}

    // Simpan ke database agar tampil di halaman notifikasi warga
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    // Isi notifikasi: judul aduan + status baru + tautan detail
    public function toArray(object $notifiable): array
    {
        return [
            'judul' => 'Aduan "' . $this->aduan->judul . '" kini: ' . ucfirst($this->aduan->status) . '.',
            'url' => route('warga.aduan.show', $this->aduan->id),
        ];
    }
}
