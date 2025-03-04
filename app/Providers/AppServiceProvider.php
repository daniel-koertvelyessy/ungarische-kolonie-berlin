<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Opcodes\LogViewer\Facades\LogViewer;

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
        LogViewer::auth(function ($request) {
            dd($request->user()->is_admin);
            if($request->user()->is_admin){
                return true;
            }
            Log::alert('Attempt to access log-viewer without Admin privileges',['user' => $request->user()]);
            return false;
        });
    }
}
