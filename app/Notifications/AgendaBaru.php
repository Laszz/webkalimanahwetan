<?php

// Notifikasi agenda baru untuk warga

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AgendaBaru extends Notification
{
    use Queueable;

    // Agenda yang baru dibuat admin
    public function __construct(public $agenda) {}

    // Simpan ke database agar tampil di halaman notifikasi warga
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    // Isi notifikasi: judul + tanggal + tautan daftar agenda
    public function toArray(object $notifiable): array
    {
        return [
            'judul' => 'Agenda baru: ' . $this->agenda->judul . ' pada ' . $this->agenda->mulai->format('d M Y') . '.',
            'url' => route('warga.agenda.index'),
        ];
    }
}
