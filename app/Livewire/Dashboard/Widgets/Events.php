<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Widgets;

use App\Enums\EventStatus;
use App\Models\Event\Event;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

final class Events extends Component
{
    public int $currentYear;

    public int $selectedYear;

    public $upcomingEventList;

    public array $yearsList = [];

    public bool $showYearSelector = false;

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

    public function mount(): void
    {
        $this->currentYear = now()->year;

        $this->selectedYear = $this->currentYear;

        //        $this->yearsList = $this->getYearsRange();
        //
        //        $this->showYearSelector = count($this->yearsList) > 1;

        $this->upcomingEventList = Event::query()
            ->whereAfterToday('event_date')
            ->whereIn('status', [EventStatus::PUBLISHED->value, EventStatus::DRAFT->value])
            ->whereYear('event_date', $this->selectedYear)
            ->orderBy('event_date')->get();

    }

    protected function getYearsRange(): array
    {
        return DB::table('events')
            ->selectRaw('DISTINCT strftime("%Y", event_date) as year')
            ->orderBy('year', 'asc')
            ->pluck('year')
            ->all();
    }

    public function render(): View
    {
        return view('livewire.dashboard.widgets.events');
    }
}
