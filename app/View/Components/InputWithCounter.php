<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

final class InputWithCounter extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $model,
        public ?string $label,
        public int $maxLength = 100,
        public string $size = 'md'
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.input-with-counter');
    }
}
