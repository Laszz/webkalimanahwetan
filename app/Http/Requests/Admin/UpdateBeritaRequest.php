<?php

// Validasi ubah berita oleh admin (aturan sama dengan berita baru)

namespace App\Http\Requests\Admin;

class UpdateBeritaRequest extends StoreBeritaRequest
{
    // Aturan warisan StoreBeritaRequest sudah mencakup semua kolom
}
