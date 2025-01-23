<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::get('lang/{locale}', function ($locale) {
    App::setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/impressum',function (){
    return view('impressum');
})->name('impressum');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {



    Route::get('/members', \App\Livewire\Member\Index\Page::class)->name('members');
    Route::get('/members/{member}', \App\Livewire\Member\Show\Page::class)->name('members.show');


    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
