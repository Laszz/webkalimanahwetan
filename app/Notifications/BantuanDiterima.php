<?php

// Notifikasi bantuan diterima untuk warga penerima

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BantuanDiterima extends Notification
{
    use Queueable;

    // Data penerima yang baru dicatat admin
    public function __construct(public $penerima) {}

    // Simpan ke database agar tampil di lonceng warga
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    // Isi notifikasi: nama bantuan + nominal + tautan detail
    public function toArray(object $notifiable): array
    {
        return [
            'judul' => 'Anda menerima bantuan "' . ($this->penerima->jenisBantuan->nama ?? 'bantuan') . '" sebesar Rp' . number_format($this->penerima->nominal, 0, ',', '.') . '.',
            'url' => route('warga.penerimabantuan.detail', $this->penerima->id),
        ];
    }
}
