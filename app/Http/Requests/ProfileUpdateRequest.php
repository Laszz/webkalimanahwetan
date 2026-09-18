<?php

// Validasi update profil akun (nama dan email)

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    // Aturan validasi nama dan email baru
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            // Email unik kecuali milik sendiri
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
        ];
    }
}
