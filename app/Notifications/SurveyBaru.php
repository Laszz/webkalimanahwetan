<?php

// Notifikasi survei baru untuk warga

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SurveyBaru extends Notification
{
    use Queueable;

    // Survei yang baru dibuka admin
    public function __construct(public $survey) {}

    // Simpan ke database agar tampil di halaman notifikasi warga
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    // Isi notifikasi: judul + tautan isi survei
    public function toArray(object $notifiable): array
    {
        return [
            'judul' => 'Survei baru: ' . $this->survey->judul . '. Silakan isi.',
            'url' => route('warga.survey.index'),
        ];
    }
}
