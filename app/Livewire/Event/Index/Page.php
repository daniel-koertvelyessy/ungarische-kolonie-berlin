<?php

namespace App\Livewire\Event\Index;

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

    public function mount(): void
    {
        $this->locale = session('locale') ?? app()->getLocale();
    }

    #[Computed]
    public function events(): LengthAwarePaginator
    {
        return Event::query()
            ->with('venue')
            ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.event.index.page');
    }
}
