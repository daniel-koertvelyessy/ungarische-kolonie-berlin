<?php

namespace App\Livewire\Blog\Post\Index;

use App\Enums\EventStatus;
use App\Models\Blog\PostType;
use App\Livewire\Traits\Sortable;
use App\Models\Blog\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Page extends Component
{
    use Sortable, WithPagination;


    public $search;
    public $filteredByStatus;
    public $filteredByType;

    public $locale;

    #[Computed]
    public function posts(): LengthAwarePaginator
    {
        return Post::query()
            ->with('images')
            ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->tap(fn ($query) => $this->search ? $query->where('title', 'LIKE', '%'.$this->search.'%')
                ->orWhere('label', 'LIKE', '%'.$this->search.'%')
                : $query)
            ->tap(fn ($query) => $this->filteredByStatus ? $query->whereIn('status', $this->filteredByStatus) : $query)
            ->tap(fn ($query) => $this->filteredByType ? $query->whereIn('post_type_id', $this->filteredByType) : $query)
            ->paginate(10);
    }

    public function mount():void
    {
        $this->search='';
        $this->filteredByStatus=EventStatus::toArray();
        $this->filteredByType = PostType::all()->pluck('id')->toArray();
        $this->locale = app()->getLocale();
    }

    public function render()
    {

        return view('livewire.blog.post.index.page');
    }
}
