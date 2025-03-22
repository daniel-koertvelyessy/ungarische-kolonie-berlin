<?php

namespace App\Livewire\Article\Index;

use App\Livewire\Traits\Sortable;
use App\Models\Article;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Page extends Component
{
    use Sortable, WithPagination;

    #[Computed]
    public function articles()
    {
        return Article::query()
            ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate(10);
    }

    #[Layout('layouts.guest')]
    public function render(): \Illuminate\View\View
    {
        return view('livewire.article.index.page');
    }
}
