<?php

namespace App\Livewire\Event\Create;

use App\Actions\Event\CreateEvent;
use App\Enums\EventStatus;
use App\Livewire\Forms\EventForm;
use App\Models\Event;
use App\Models\Venue;
use App\Rules\UniqueJsonSlug;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Page extends Component
{

    public EventForm $form;

    #[Computed]
    public function venues()
    {
        return Venue::select('id', 'name')
            ->get();
    }

    public function createEventData()
    {
        $this->authorize('create', Event::class);
        $this->form->create();
   }

    public function render()
    {
        return view('livewire.event.create.page');
    }
}
