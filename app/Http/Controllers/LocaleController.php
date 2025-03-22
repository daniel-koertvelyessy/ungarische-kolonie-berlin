<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;

class LocaleController extends Controller
{
    /**
     * Switch the application locale and redirect back.
     *
     * @param  string  $locale  The desired locale (e.g., 'en', 'hu')
     */
    public function switch(string $locale): RedirectResponse
    {
        App::setLocale($locale);
        session()->put('locale', $locale);

        return redirect()->back();
    }
}
