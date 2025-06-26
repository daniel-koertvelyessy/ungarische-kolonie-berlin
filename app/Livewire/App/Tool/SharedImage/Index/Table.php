<?php

declare(strict_types=1);

namespace App\Livewire\App\Tool\SharedImage\Index;

use App\Models\SharedImage;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 *  List images as Table with META data
 */
class Table extends Component
{
    use \Livewire\WithPagination;

    #[Computed]
    public function images(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return SharedImage::latest()->paginate(10);
    }

    public function render(): View
    {
        return view('livewire.app.tool.shared-image.index.table');
    }
}
