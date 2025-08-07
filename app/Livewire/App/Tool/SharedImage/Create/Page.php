<?php

declare(strict_types=1);

namespace App\Livewire\App\Tool\SharedImage\Create;

use Livewire\Component;

final class Page extends Component
{
    public function render()
    {
        return view('livewire.app.tool.shared-image.create.page')->title('Bild hochladen');
    }
}
