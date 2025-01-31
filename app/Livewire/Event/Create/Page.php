<?php

namespace App\Livewire\Event\Create;

use App\Livewire\Forms\EventForm;
use App\Models\Venue;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Page extends Component
{

    public EventForm $form;

    #[Computed]
    public function venues()
    {
        return Venue::select('id','name')->get();
    }

    public function render()
    {
        return view('livewire.event.create.page');
    }
}
