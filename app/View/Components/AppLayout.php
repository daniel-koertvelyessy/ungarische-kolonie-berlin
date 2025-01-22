<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    public string $title = 'Magyar Kolónia Berlin e.V.';

    public function __construct(?string $title)
    {
        if ($title) {
            $this->title = $title . ' | Magyar Kolónia Berlin e.V.';
        } else {
            $this->title = 'Magyar Kolónia Berlin e.V.';
        }

    }
    public function render(): View
    {
        return view('layouts.app');
    }
}
