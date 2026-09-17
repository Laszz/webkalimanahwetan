<?php

// Validasi ubah layanan oleh admin (aturan sama dengan layanan baru)

namespace App\Http\Requests\Admin;

class UpdateLayananRequest extends StoreLayananRequest
{
    // Aturan warisan StoreLayananRequest sudah mencakup semua kolom
}
