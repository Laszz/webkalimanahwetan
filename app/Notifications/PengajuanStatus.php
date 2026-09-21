<?php

// Notifikasi perubahan status pengajuan layanan untuk pemohon

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PengajuanStatus extends Notification
{
    use Queueable;

    // Pengajuan yang statusnya diubah admin (sudah berisi status baru)
    public function __construct(public $pengajuan) {}

    // Simpan ke database agar tampil di halaman notifikasi warga
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    // Isi notifikasi: nama layanan + status baru + tautan riwayat pengajuan
    public function toArray(object $notifiable): array
    {
        return [
            'judul' => 'Pengajuan "' . ($this->pengajuan->layanan->nama ?? 'layanan') . '" kini: ' . ucfirst($this->pengajuan->status) . '.',
            'url' => route('warga.pengajuan.index'),
        ];
    }
}
