<?php

// Validasi ubah jenis bantuan oleh admin (aturan sama dengan jenis baru)

namespace App\Http\Requests\Admin;

class UpdateJenisBantuanRequest extends StoreJenisBantuanRequest
{
    // Aturan warisan StoreJenisBantuanRequest sudah mencakup semua kolom
}
