<?php

namespace App\Livewire\Event\Show;

use App\Livewire\Forms\EventForm;
use App\Livewire\Traits\HasPrivileges;
use App\Livewire\Traits\PersistsTabs;
use App\Livewire\Traits\Sortable;
use App\Models\Event\Event;
use App\Models\Event\EventSubscription;
use App\Models\Event\EventTransaction;
use App\Models\Event\EventVisitor;
use App\Models\Venue;
use Flux\Flux;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Page extends Component
{
    use HasPrivileges, PersistsTabs, Sortable, WithPagination;

    public EventForm $form;

    public $event_id;

    public Event $event;

    public string $selectedTab = 'event-show-dates';

    protected $listeners = [
        'updated-payments' => 'payments',
        'event-visitor-added' => 'visitors',
    ];

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
            ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate(10);
    }

    #[Computed]
    public function visitors(): LengthAwarePaginator
    {
        return EventVisitor::query()
            ->with('member')
            ->where('event_id', '=', $this->event_id)
            ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate(10);
    }

    public function mount(Event $event)
    {
        $this->event_id = $event->id;
        $this->form->setEvent($event);
        $this->selectedTab = $this->getSelectedTab();
    }

    public function addVisitor(): void
    {
        $this->checkPrivilege(Event::class);
        Flux::modal('add-new-visitor')->show();
    }

    public function updateEventData(): void
    {
        $this->checkPrivilege(Event::class);
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

    public function generateEventReport() {}

    public function render()
    {
        return view('livewire.event.show.page');
    }
}
