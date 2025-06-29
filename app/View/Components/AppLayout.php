<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    public string $title = 'Magyar Kolónia Berlin e.V.';

    public int $counter = 0;

    public function __construct(?string $title)
    {
        if ($title) {
            $this->title = $title.' | Magyar Kolónia Berlin e.V.';
        } else {
            $this->title = 'Magyar Kolónia Berlin e.V.';
        }
    }

    public function mount(): void {}

    /**
     * Get the view / view contents that represent the component.
     */
    public function render(): View
    {
        return view('layouts.app');
    }
}
