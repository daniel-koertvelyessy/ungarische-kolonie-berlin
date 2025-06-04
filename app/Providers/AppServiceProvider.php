<?php

namespace App\Providers;

use App\Services\MailingService;
use Illuminate\Support\ServiceProvider;
use Opcodes\LogViewer\Facades\LogViewer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(MailingService::class, function ($app) {

            return new MailingService;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        LogViewer::auth(function ($request) {
            return true;
        });

        putenv('MAGICK_GHOSTSCRIPT_PATH='.(PHP_OS_FAMILY === 'Darwin'
                ? '/opt/homebrew/bin/gs'
                : '/usr/bin/gs'
        ));
    }
}
