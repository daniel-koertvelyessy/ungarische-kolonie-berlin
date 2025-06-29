<?php

declare(strict_types=1);

use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return json_encode([
        'version' => '1.0.0',
        'released_at' => '2025-06-13',
    ]);
});

Route::get('/feed/events', [EventController::class, 'rssFeed'])->name('api.events.feed');

Route::prefix('v1')->group(function () {
    Route::get('/events', [EventController::class, 'apiIndex'])->name('api.events.index');
    Route::get('/events-all', [EventController::class, 'apiAll'])->name('api.events.all');

    Route::get('/event/{slug}', [EventController::class, 'apiShow'])->name('api.v1.event.show');
});
