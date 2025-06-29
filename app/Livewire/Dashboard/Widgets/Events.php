<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Widgets;

use App\Enums\EventStatus;
use App\Models\Event\Event;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Events extends Component
{
    #[Computed]
    public function draftedEvents(): int
    {
        return Event::where('status', EventStatus::DRAFT->value)->count();
    }

    #[Computed]
    public function publishedEvents(): int
    {
        return Event::where('status', EventStatus::PUBLISHED->value)->count();
    }

    #[Computed]
    public function pendingEvents(): int
    {
        return Event::where('status', EventStatus::PENDING)->count();
    }

    public function render(): view
    {
        return view('livewire.dashboard.widgets.events');
    }
}
