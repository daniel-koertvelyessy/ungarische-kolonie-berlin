<?php

namespace App\Livewire\Event\Index;

use App\Enums\EventStatus;
use App\Livewire\Traits\Sortable;
use App\Models\Event\Event;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Page extends Component
{
    use Sortable, WithPagination;

    public string $locale;

    public $search = '';

    public $filteredBy = [
        EventStatus::DRAFT->value,
        EventStatus::PUBLISHED->value,
    ];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function mount(): void
    {
        $this->locale = session('locale') ?? app()->getLocale();
        $this->sortBy = 'event_date';
        $this->sortDirection = 'desc';
    }

    #[Computed]
    public function events(): LengthAwarePaginator
    {
        return Event::query()
            ->with('venue')
            ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->tap(fn ($query) => $this->search ? $query->where('title', 'LIKE', '%'.$this->search.'%')
                ->orWhere('name', 'LIKE', '%'.$this->search.'%')
                : $query)
            ->tap(fn ($query) => $this->filteredBy ? $query->whereIn('status', $this->filteredBy) : $query)
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.event.index.page');
    }
}
