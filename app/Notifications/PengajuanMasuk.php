<?php

// Notifikasi pengajuan layanan baru untuk admin

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PengajuanMasuk extends Notification
{
    use Queueable;

    // Pengajuan yang baru dikirim warga
    public function __construct(public $pengajuan) {}

    // Simpan ke database agar tampil di dashboard admin
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    // Isi notifikasi: layanan + pemohon + tautan periksa
    public function toArray(object $notifiable): array
    {
        return [
            'judul' => 'Pengajuan baru "' . ($this->pengajuan->layanan->nama ?? 'layanan') . '" dari ' . ($this->pengajuan->user->name ?? 'warga') . '.',
            'url' => route('admin.pengajuan.show', $this->pengajuan->id),
        ];
    }
}
