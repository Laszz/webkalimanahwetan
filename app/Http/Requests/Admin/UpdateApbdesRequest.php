<?php

// Validasi ubah pos APBDes oleh admin (aturan sama dengan pos baru)

namespace App\Http\Requests\Admin;

class UpdateApbdesRequest extends StoreApbdesRequest
{
    // Aturan warisan StoreApbdesRequest sudah mencakup semua kolom
}
