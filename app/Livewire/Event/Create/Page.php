<?php

declare(strict_types=1);

namespace App\Livewire\Event\Create;

use App\Livewire\Forms\Event\EventForm;
use App\Models\Event\Event;
use App\Models\Venue;
use Flux\Flux;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Page extends Component
{
    public EventForm $form;

    #[Computed]
    public function venues(): Collection
    {
        return Venue::select('id', 'name')
            ->get();
    }

    public function createEventData(): void
    {
        $this->authorize('create', Event::class);
        $newEvent = $this->form->create();
        Flux::toast(
            text: __('event.store.success.content'),
            heading: __('event.store.success.title'),
            variant: 'success',
        );
        //        $this->dispatch('navigate-to', route('backend.events.index'));
        $this->redirect(route('backend.events.show', $newEvent));
    }

    public function render(): View
    {
        return view('livewire.event.create.page');
    }
}
