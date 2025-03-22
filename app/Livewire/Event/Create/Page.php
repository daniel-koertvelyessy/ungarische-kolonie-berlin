<?php

namespace App\Livewire\Event\Create;

use App\Livewire\Forms\Event\EventForm;
use App\Models\Event\Event;
use App\Models\Venue;
use Flux\Flux;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Page extends Component
{
    public EventForm $form;

    #[Computed]
    public function venues(): \Illuminate\Database\Eloquent\Collection
    {
        return Venue::select('id', 'name')
            ->get();
    }

    public function createEventData(): void
    {
        $this->authorize('create', Event::class);
        $new_event = $this->form->create();
        Flux::toast(
            text: __('event.store.success.content'),
            heading: __('event.store.success.title'),
            variant: 'success',
        );
        //        $this->dispatch('navigate-to', route('backend.events.index'));
        $this->redirect(route('backend.events.show', $new_event));
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.event.create.page');
    }
}
