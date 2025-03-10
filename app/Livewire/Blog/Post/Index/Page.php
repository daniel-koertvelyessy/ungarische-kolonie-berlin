<?php

namespace App\Livewire\Blog\Post\Index;

use App\Livewire\Traits\Sortable;
use App\Models\Blog\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Page extends Component
{

    use Sortable, WithPagination;

    #[Computed]
    public function posts(): LengthAwarePaginator
    {
        return Post::query()
            ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate(10);
    }

    #[Layout('layouts.guest')]
    public function render()
    {

        return view('livewire.blog.post.index.page');
    }

}
