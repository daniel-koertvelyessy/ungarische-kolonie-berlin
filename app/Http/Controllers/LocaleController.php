<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocaleController extends Controller
{

    /**
     * Switch the application locale and redirect back.
     *
     * @param string $locale The desired locale (e.g., 'en', 'hu')
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switch(string $locale)
    {
        App::setLocale($locale);
        session()->put('locale', $locale);
        return redirect()->back();
    }
}
