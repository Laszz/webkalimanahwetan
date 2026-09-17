<?php

// Validasi ubah perangkat desa oleh admin (aturan sama dengan perangkat baru)

namespace App\Http\Requests\Admin;

class UpdatePerangkatDesaRequest extends StorePerangkatDesaRequest
{
    // Aturan warisan StorePerangkatDesaRequest sudah mencakup semua kolom
}
