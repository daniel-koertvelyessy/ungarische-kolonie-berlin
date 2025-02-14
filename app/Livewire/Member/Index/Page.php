<?php

namespace App\Livewire\Member\Index;

use App\Enums\MemberType;
use Livewire\Component;

class Page extends Component
{

    use \Livewire\WithPagination;

    public $sortBy = 'date';
    public $sortDirection = 'desc';

    public $search = '';

    public $filteredBy= [
      MemberType::AP->value,
      MemberType::MD->value,
      MemberType::ST->value,
      MemberType::AD->value,
    ];

    public function sort($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    #[\Livewire\Attributes\Computed]
    public function members()
    {
        return \App\Models\Membership\Member::query()
            ->tap(fn($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->tap(fn($query) => $this->search ? $query->where('name', 'LIKE', '%'.$this->search.'%')
                ->orWhere('first_name', 'LIKE', '%'.$this->search.'%')
                ->orWhere('email', 'LIKE', '%'.$this->search.'%')
                ->orWhere('bith_place', 'LIKE', '%'.$this->search.'%')
                : $query)
            ->tap(fn($query) => $this->filteredBy ? $query->whereIn('type', $this->filteredBy) : $query)
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.member.index.page');
    }
}
