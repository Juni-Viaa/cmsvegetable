<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\WhatsAppService;
use App\Services\OtpService;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        // Register WhatsApp Service
        $this->app->singleton(WhatsAppService::class, function ($app) {
            return new WhatsAppService();
        });

        // Register OTP Service
        $this->app->singleton(OtpService::class, function ($app) {
            return new OtpService($app->make(WhatsAppService::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
