<?php

namespace App\Livewire\Event\Show;

use App\Enums\Locale;
use App\Livewire\Forms\EventForm;
use App\Models\Event;
use App\Models\EventSubscription;
use App\Models\EventTransaction;
use App\Models\Membership\MemberTransaction;
use App\Models\Venue;
use Flux\Flux;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Page extends Component
{
    use WithPagination;

    public EventForm $form;
    public $event_id;
    public $sortBy = 'date';
    public $sortDirection = 'desc';
    public Event $event;
    public $tab = 'dates';
    protected $listeners = ['updated-payments' => 'payments'];

    public function sort($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    #[Computed]
    public function subscriptions()
    {
        return EventSubscription::where('event_id', $this->event_id)->paginate(10);
    }

    #[Computed]
    public function venues()
    {
        return Venue::select('id', 'name')
            ->get();
    }

    #[Computed]
    public function payments(): LengthAwarePaginator
    {
        return EventTransaction::query()
            ->with('transaction')
            ->where('event_id', '=', $this->event_id)
            ->tap(fn($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate(10);
    }


    public function mount(Event $event)
    {
        $this->event_id = $event->id;
        $this->form->setEvent($event);
    }


    public function updateEventData(): void
    {
        try {
            $this->authorize('update', $this->form->event);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            Flux::toast(
                text: 'You have no permission to edit this member! '.$e->getMessage(),
                heading: 'Forbidden',
                variant: 'danger',
            );
            return;
        }
        $this->form->update();
    }

    #[On('image-uploaded')]
    public function storeImage($file): void
    {
        if ($this->form->storeImage($file)) {
            Flux::toast(
                text: __('event.store_image.success.content'),
                heading: __('event.store_image.success.title'),
                variant: 'success',
            );
        } else {
            dd('fehler');
        }
    }

    #[On('new-venue-created')]
    public function assignVenue(): void {}

    public function deleteImage(): void
    {
        if ($this->form->deleteImage()) {
            Flux::toast(
                text: __('event.delete_image.success.content'),
                heading: __('event.delete_image.success.title'),
                variant: 'success',
            );
        } else {
            dd('fehler');
        }
    }

    public function render()
    {
        return view('livewire.event.show.page');
    }
}
