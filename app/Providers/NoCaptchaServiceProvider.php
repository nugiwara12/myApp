<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Anhskohbo\NoCaptcha\NoCaptcha;

class NoCaptchaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('captcha', function ($app) {
            return new NoCaptcha(
                config('captcha.secret'),
                config('captcha.sitekey')
            );
        });
    }

    public function boot(): void
    {
        //
    }
}
