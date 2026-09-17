<?php

// Validasi ubah biodata warga (aturan sama dengan biodata baru)

namespace App\Http\Requests\Warga;

class UpdateWargaRequest extends StoreWargaRequest
{
    // Aturan warisan StoreWargaRequest sudah mencakup semua kolom
}
