<?php

namespace App\Livewire\Event\Index;

use App\Models\Event;
use App\Models\Member;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Page extends Component
{


    use WithPagination;

    public $sortBy = 'date';
    public $sortDirection = 'desc';
    public string $locale;

    public function sort($column) {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function mount()
    {
        $this->locale = session('locale') ?? app()->getLocale();
    }

    #[Computed]
    public function events()
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
