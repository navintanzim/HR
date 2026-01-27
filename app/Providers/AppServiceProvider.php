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
        view()->addNamespace('leaves', base_path('app/Modules/Leaves/Views'));
        view()->addNamespace('users', base_path('app/Modules/Users/Views'));
    }
}
