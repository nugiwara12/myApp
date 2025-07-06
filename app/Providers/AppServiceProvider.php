<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use App\Models\ActivityLog;

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
        Event::listen(Login::class, function ($event) {
            ActivityLog::create([
                'user_id' => $event->user->id,
                'name' => $event->user->name,
                'email' => $event->user->email,
                'role' => $event->user->roles()->pluck('name')->first(), // if using Spatie
                'description' => 'User logged in'
            ]);
        });

        // Log Logout
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

        // Log Register
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
