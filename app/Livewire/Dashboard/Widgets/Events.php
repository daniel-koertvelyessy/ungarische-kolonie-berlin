<?php

namespace App\Livewire\Dashboard\Widgets;

use App\Enums\EventStatus;
use App\Models\Event\Event;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Events extends Component
{
    #[Computed]
    public function draftedEvents()
    {
        return Event::where('status', EventStatus::DRAFT->value)->count();
    }

    #[Computed]
    public function publishedEvents()
    {
        return Event::where('status', EventStatus::PUBLISHED->value)->count();
    }

    #[Computed]
    public function pendingEvents()
    {
        return Event::where('status', EventStatus::PENDING)->count();
    }

    public function render()
    {
        return view('livewire.dashboard.widgets.events');
    }
}
