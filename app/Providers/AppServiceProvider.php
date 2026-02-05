<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;

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
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        if (env('CLOUDINARY_URL')) {
            Config::set('cloudinary.cloud_url', env('CLOUDINARY_URL'));
            Config::set('cloudinary.upload_preset', env('CLOUDINARY_UPLOAD_PRESET'));
            Config::set('cloudinary.notification_url', env('CLOUDINARY_NOTIFICATION_URL'));
        }
    }
}
