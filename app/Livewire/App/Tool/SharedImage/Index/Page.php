<?php

declare(strict_types=1);

namespace App\Livewire\App\Tool\SharedImage\Index;

use Illuminate\View\View;
use Livewire\Component;

final class Page extends Component
{
    public string $viewMode = 'grid';

    public function toggleViewMode(): void
    {
        $this->viewMode = $this->viewMode === 'grid' ? 'table' : 'grid';
    }

    public function render(): View
    {
        return view('livewire.app.tool.shared-image.index.page', [
            'viewMode' => $this->viewMode,
        ])->title('Bildübersicht');
    }
}
