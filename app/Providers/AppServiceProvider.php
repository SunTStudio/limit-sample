<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Membuat direktif Blade kustom @hasRole
        Blade::directive('hasRole', function ($role) {
            return "<?php if(in_array($role, session('roles', []))): ?>";
        });

        // Menutup direktif kustom
        Blade::directive('endhasRole', function () {
            return "<?php endif; ?>";
        });
    }
}
