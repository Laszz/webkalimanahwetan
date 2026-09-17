<?php

// Validasi ubah agenda oleh admin (aturan sama dengan agenda baru)

namespace App\Http\Requests\Admin;

class UpdateAgendaRequest extends StoreAgendaRequest
{
    // Aturan warisan StoreAgendaRequest sudah mencakup semua kolom
}
