<?php

namespace App\Livewire\Venue\Create;

use App\Livewire\Forms\VenueForm;
use App\Models\Venue;
use Flux\Flux;
use Livewire\Component;

class Page extends Component
{

    public VenueForm $form;


    public function storeVenue()
    {
      $id = $this->form->store();



      if ($id>0) {
          $this->dispatch('new-venue-created');
          Flux::modal('add-new-venue')->close();
      }

    }

    public function render()
    {
        return view('livewire.venue.create.page');
    }
}
