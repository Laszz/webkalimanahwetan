<?php

namespace App\Providers;

use App\Models\ProfilDesa;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Logo desa untuk navbar (null = pakai teks); cache DB agar tidak query tiap partial
        View::composer('partials.navbar', function ($view) {
            $view->with('logoDesa', cache()->remember(
                'logo-desa',
                now()->addHour(),
                fn () => ProfilDesa::first()?->logo
            ));
        });
    }
}
