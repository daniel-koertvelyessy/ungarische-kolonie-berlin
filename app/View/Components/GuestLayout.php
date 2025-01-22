<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{

    public string $title = 'Magyar Kolónia Berlin e.V.';

    public function __construct(string $title)
    {
        $this->title = $title . ' | Magyar Kolónia Berlin e.V.';
    }

    public function render(): View
    {
        return view('layouts.guest');
    }
}
