<?php

namespace App\View\Components;

use App\Models\Event\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{
    public string $title = 'Magyar Kolónia Berlin e.V.';
    public bool $is_login_page = false;
    public bool $hasEvent = false;
    public ?Event $event = null;
    public string $locale;

    public function __construct(?string $title = null, bool $is_login_page = false, $event = null)
    {
        // Set the page title
        $this->title = $title ? $title . ' | Magyar Kolónia Berlin e.V.' : 'Magyar Kolónia Berlin e.V.';

        // Ensure $is_login_page is a boolean
        $this->is_login_page = filter_var($is_login_page, FILTER_VALIDATE_BOOLEAN);

        // Handle the event with stricter checking
        if ($event instanceof Event && $event->exists) { // Only set if it's a valid, loaded Event model
            $this->event = $event;
            $this->hasEvent = true;
        } else {
            $this->event = null;
            $this->hasEvent = false;
        }

        // Set the locale (default to 'de' if not set)
        $this->locale = app()->getLocale() ?? 'de';
    }


    public function render(): View
    {
        return view('layouts.guest');
    }
}
