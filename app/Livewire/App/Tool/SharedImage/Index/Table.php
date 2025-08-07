<?php

declare(strict_types=1);

namespace App\Livewire\App\Tool\SharedImage\Index;

use App\Models\SharedImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 *  List images as Table with META data
 */
final class Table extends Component
{
    use \Livewire\WithPagination;

    protected $listeners = ['image-updated' => '$refresh'];

    #[Computed]
    public function images(): \Illuminate\Pagination\LengthAwarePaginator
    {
        $query = SharedImage::latest();

        if (! Auth::user()->isBoardMember()) {
            $query->where('is_appoved', '=', true);
        }

        return $query->paginate(20);
    }

    public function render(): View
    {
        return view('livewire.app.tool.shared-image.index.table');
    }
}
