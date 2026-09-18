<?php

// Command artisan admin:make - buat atau perbarui akun admin dari env/pilihan

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeAdmin extends Command
{
    // Nama command + pilihan penimpa env (prioritas: pilihan > env)
    protected $signature = 'admin:make
        {--name= : Nama admin (default dari ADMIN_NAME)}
        {--email= : Email admin (default dari ADMIN_EMAIL)}
        {--password= : Password plain (default dari ADMIN_PASSWORD)}';

    // Deskripsi untuk daftar artisan list
    protected $description = 'Buat atau perbarui akun admin dari env ADMIN_*';

    // Jalankan: ambil data, validasi, simpan sebagai admin aktif
    public function handle(): int
    {
        // Ambil dari pilihan dulu, jatuh ke env
        $name = $this->option('name') ?: env('ADMIN_NAME');
        $email = $this->option('email') ?: env('ADMIN_EMAIL');
        $password = $this->option('password') ?: env('ADMIN_PASSWORD');

        // Semua wajib ada agar tidak tercipta admin setengah jadi
        if (! $name || ! $email || ! $password) {
            $this->error('Lengkapi ADMIN_NAME, ADMIN_EMAIL, ADMIN_PASSWORD di .env atau via --name/--email/--password.');
            return self::FAILURE;
        }

        // Buat baru atau perbarui milik email ini; password plain otomatis di-hash oleh cast model
        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => $password,
                'role' => 'admin',
                'status' => 'disetujui',
                'email_verified_at' => now(),
            ],
        );

        $this->info("Admin siap: {$user->name} <{$user->email}>");

        return self::SUCCESS;
    }
}
