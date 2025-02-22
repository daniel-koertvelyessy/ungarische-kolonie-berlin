<?php

namespace App\Livewire\Member\Index;

use App\Enums\MemberType;
use App\Livewire\Traits\Sortable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Page extends Component
{
    use Sortable;
    use WithPagination;

    public $search = '';

    public $filteredBy = [
        MemberType::AP->value,
        MemberType::MD->value,
        MemberType::ST->value,
        MemberType::AD->value,
    ];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function members(): LengthAwarePaginator
    {
        return \App\Models\Membership\Member::query()
            ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->tap(fn ($query) => $this->search ? $query->where('name', 'LIKE', '%'.$this->search.'%')
                ->orWhere('first_name', 'LIKE', '%'.$this->search.'%')
                ->orWhere('email', 'LIKE', '%'.$this->search.'%')
                ->orWhere('bith_place', 'LIKE', '%'.$this->search.'%')
                : $query)
            ->tap(fn ($query) => $this->filteredBy ? $query->whereIn('type', $this->filteredBy) : $query)
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.member.index.page');
    }
}
