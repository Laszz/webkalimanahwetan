<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\AkunBaru;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            // Kecocokan dicek via password_confirmation+same agar pesannya tampil di bawah kolom konfirmasi
            'password' => ['required', Rules\Password::defaults()],
            'password_confirmation' => ['required', 'same:password'],
        ], [
            'password.required' => 'Silakan isi password.',
            'password.min' => 'Password minimal 8 karakter.',
            'password_confirmation.required' => 'Silakan isi konfirmasi password.',
            'password_confirmation.same' => 'Konfirmasi password tidak sama dengan password.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // Beri tahu semua admin agar segera diverifikasi
        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new AkunBaru($user));

        // Tidak langsung masuk: akun baru berstatus menunggu, admin verifikasi dulu.
        // Pesan tampil di halaman login via session status
        return redirect(route('login', absolute: false))->with(
            'status',
            'Pendaftaran terkirim. Akun anda sedang menunggu persetujuan admin.'
        );
    }
}
