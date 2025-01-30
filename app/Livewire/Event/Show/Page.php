<?php

namespace App\Livewire\Event\Show;

use App\Enums\Locale;
use App\Livewire\Forms\EventForm;
use App\Models\Event;
use App\Models\Venue;
use Flux\Flux;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class Page extends Component
{

  public EventForm $form;



    #[Computed]
    public function venues()
    {
        return Venue::select('id','name')->get();
    }


    public function mount(Event $event)
    {

        $this->form->setEvent($event);
    }



    public function updateEventData(): void{

        try {
            $this->authorize('update', $this->form->event);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            Flux::toast(
                heading: 'Forbidden',
                text: 'You have no permission to edit this member! '.$e->getMessage(),
                variant: 'danger',
            );
            return;
        }
        $this->form->update();
    }

    #[On('image-uploaded')]
    public function storeImage($file):void
    {
        if ($this->form->storeImage($file)){

            Flux::toast(
                heading: __('event.store_image.success.title'),
                text: __('event.store_image.success.content'),
                variant: 'success',
            );
        } else{
            dd('fehler');
        }
    }

    #[On('new-venue-created')]
    public function assignVenue():void
    {

    }

    public function deleteImage():void
    {
        if ($this->form->deleteImage()){
            Flux::toast(
                heading: __('event.delete_image.success.title'),
                text: __('event.delete_image.success.content'),
                variant: 'success',
            );
        } else{
            dd('fehler');
        }
    }

    public function render()
    {
        return view('livewire.event.show.page');
    }
}
