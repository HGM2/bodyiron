<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Eliminamos la configuración dinámica del menú para mantener el código limpio.
    }

    protected $policies = [
        Cliente::class => ClientePolicy::class,
    ];
}
