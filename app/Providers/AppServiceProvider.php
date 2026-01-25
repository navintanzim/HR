<?php

namespace App\Providers;

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
        view()->addNamespace('settings', base_path('app/Modules/Settings/Views'));
        view()->addNamespace('employees', base_path('app/Modules/Employees/Views'));
    }
}
