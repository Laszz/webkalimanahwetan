<?php

// Notifikasi survei diisi warga untuk admin

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SurveyDiisi extends Notification
{
    use Queueable;

    // Survei yang baru diisi + nama pengisi
    public function __construct(public $survey, public $namaPengisi) {}

    // Simpan ke database agar tampil di dashboard admin
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    // Isi notifikasi: survei + pengisi + tautan hasil
    public function toArray(object $notifiable): array
    {
        return [
            'judul' => 'Survei "' . $this->survey->judul . '" diisi oleh ' . $this->namaPengisi . '.',
            'url' => route('admin.survey.show', $this->survey->id),
        ];
    }
}
