<?php

// Validasi ubah survei oleh admin (aturan sama dengan survei baru)

namespace App\Http\Requests\Admin;

class UpdateSurveyRequest extends StoreSurveyRequest
{
    // Aturan warisan StoreSurveyRequest sudah mencakup semua kolom
}
