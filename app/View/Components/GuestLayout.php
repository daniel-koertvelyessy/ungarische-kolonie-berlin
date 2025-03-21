<?php

namespace App\View\Components;

use App\Models\Event\Event;
use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{
    public string $title = 'Magyar Kolónia Berlin e.V.';

    public bool $is_login_page = false;

    public bool $hasEvent = false;

    public ?Event $event = null;

    public string $locale;

    public function __construct(?string $title = null, bool $is_login_page = false, ?Event $event = null)
    {
        // Default values
        $this->title = $title ?: 'Magyar Kolónia Berlin e.V.';  // Use provided title or fallback to default
        $this->is_login_page = $is_login_page;  // Use provided value or default to false
        $this->event = $event;  // Event can be null
        $this->hasEvent = $event instanceof Event; // Check if event exists
        $this->locale = app()->getLocale(); // Default to 'de' if no locale is set
    }

    public function render(): View
    {
        return view('layouts.guest', [
            'title' => $this->title,
            'event' => $this->event,
            'hasEvent' => $this->hasEvent,
            'locale' => $this->locale,
        ]);
    }
}
