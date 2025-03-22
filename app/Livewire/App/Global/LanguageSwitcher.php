<?php

namespace App\Livewire\App\Global;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class LanguageSwitcher extends Component
{
    public string $currentLocale;

    public function mount(): void
    {
        $this->currentLocale = App::getLocale();
    }

    public function switchLanguage(string $locale): \Illuminate\Http\RedirectResponse
    {
        if (! in_array($locale, ['en', 'de', 'hu'])) {
            abort(404);
        }

        App::setLocale($locale);
        Session::put('locale', $locale);
        $this->currentLocale = $locale;

        // Optional: Seite aktualisieren, um Sprachänderung sofort zu reflektieren
        return redirect(request()->header('Referer'));
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.app.global.language-switcher');
    }
}
