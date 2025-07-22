<?php

namespace App\Providers;

use App\View\CustomViewFinder;
use App\Providers\AdminPanelProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use App\Models\ActivityLog;
use Illuminate\Filesystem\Filesystem;
use Filament\Facades\Filament;

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
        // ✅ Register Admin Panel with Filament
        // Filament::registerPanels([
        //     AdminPanelProvider::class,
        // ]);

        // ✅ Bind Custom View Finder
        $this->app->bind('view.finder', function ($app) {
            return new CustomViewFinder(
                new Filesystem,
                $app['config']['view.paths']
            );
        });

        // ✅ Event: Login
        Event::listen(Login::class, function ($event) {
            ActivityLog::create([
                'user_id' => $event->user->id,
                'name' => $event->user->name,
                'email' => $event->user->email,
                'role' => $event->user->roles()->pluck('name')->first(),
                'description' => 'User logged in'
            ]);
        });

        // ✅ Event: Logout
        Event::listen(Logout::class, function ($event) {
            if ($event->user) {
                ActivityLog::create([
                    'user_id' => $event->user->id,
                    'name' => $event->user->name,
                    'email' => $event->user->email,
                    'role' => $event->user->roles()->pluck('name')->first(),
                    'description' => 'User logged out'
                ]);
            }
        });

        // ✅ Event: Registered
        Event::listen(Registered::class, function ($event) {
            ActivityLog::create([
                'user_id' => $event->user->id,
                'name' => $event->user->name,
                'email' => $event->user->email,
                'role' => $event->user->roles()->pluck('name')->first(),
                'description' => 'User registered'
            ]);
        });
    }
}
