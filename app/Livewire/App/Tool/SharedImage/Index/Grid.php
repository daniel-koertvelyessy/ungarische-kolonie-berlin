<?php

declare(strict_types=1);

namespace App\Livewire\App\Tool\SharedImage\Index;

use App\Models\SharedImage;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 *  Display images in a grid layout
 */
class Grid extends Component
{

    #[Computed]
    public function images()
    {
      return SharedImage::latest()->get();
    }

    public function render():View
    {
        return view('livewire.app.tool.shared-image.index.grid');
    }
}
