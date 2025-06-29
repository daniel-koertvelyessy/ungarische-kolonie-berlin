<?php

declare(strict_types=1);

namespace App\Livewire\App\Tool\SharedImage\Index;

use App\Models\SharedImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

/**
 *  Display images in a grid layout
 */
class Grid extends Component
{
    use WithPagination;

    protected $listeners = ['image-updated' => '$refresh'];

    #[Computed]
    public function images()
    {

        $query = SharedImage::latest()->where('user_id', '=', Auth::user()->id);

        if (! Auth::user()->isBoardMember()) {
            $query->orWhere('is_appoved', '=', true);
        }

        return $query->paginate(20);
    }

    public function render(): View
    {
        return view('livewire.app.tool.shared-image.index.grid');
    }
}
