<?php

// Validasi ubah pertanyaan survei oleh admin (aturan sama dengan pertanyaan baru)

namespace App\Http\Requests\Admin;

class UpdatePertanyaanRequest extends StorePertanyaanRequest
{
    // Aturan warisan StorePertanyaanRequest sudah mencakup semua kolom
}
