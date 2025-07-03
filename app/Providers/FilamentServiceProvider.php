<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Gate authorization for Filament access
        Gate::define('viewFilament', function ($user) {
            return $user->hasAnyRole(['admin', 'user', 'encoder', 'staff']);
        });

        // Apply the gate for Filament
        Filament::serving(function () {
            Filament::authorizeGate('viewFilament');
        });
    }
}
