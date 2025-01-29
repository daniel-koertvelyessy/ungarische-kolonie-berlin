<?php

namespace App\Livewire\Event\Show;

use App\Enums\Locale;
use App\Models\Event;
use App\Models\Venue;
use Flux\Flux;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Page extends Component
{

    public Event $event;
    public string $locale;
    public array $locales;

    public $event_date;
    public $start_time;
    public $end_time;
    public $entry_fee;
    public $entry_fee_discounted;

    public array $title;
    public array $slug;
    public array $description;
    public int $venue_id;



    #[Computed]
    public function venues()
    {
        return Venue::select('id','name')->get();
    }


    public function mount($event)
    {

        $this->event = $event;

        $this->locale = session('locale') ?? app()->getLocale();
        $this->locales = Locale::toArray();
        $this->populate();
    }

    private function populate():void{
        $this->event_date = $this->event->event_date->format('Y-m-d');
        $this->start_time = $this->event->start_time->format('H:i');
        $this->end_time = $this->event->end_time->format('H:i');
        $this->title = $this->event->title;
        $this->slug = $this->event->slug;
        $this->description = $this->event->description;
        $this->entry_fee = $this->event->entry_fee;
        $this->entry_fee_discounted = $this->event->entry_fee_discounted;
        $this->venue_id = $this->event->venue_id;
    }

    public function updateEventData(): void{

        try {
            $this->authorize('update', $this->event);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            Flux::toast(
                heading: 'Forbidden',
                text: 'You have no permission to edit this member! '.$e->getMessage(),
                variant: 'danger',
            );
            return;
        }

        $this->event->event_date = $this->event_date;
        $this->event->start_time = $this->start_time;
        $this->event->end_time = $this->end_time;
        $this->event->title = $this->title;
        $this->event->slug = $this->slug;
        $this->event->description = $this->description;
        $this->event->entry_fee = $this->entry_fee;
        $this->event->entry_fee_discounted = $this->entry_fee_discounted;
        $this->event->venue_id = $this->venue_id;

        if ($this->event->save()) {
            Flux::toast(
                heading: __('members.update.success.title'),
                text: __('members.update.success.content'),
                variant: 'success',
            );
        }

    }
    public function render()
    {
        return view('livewire.event.show.page');
    }
}
