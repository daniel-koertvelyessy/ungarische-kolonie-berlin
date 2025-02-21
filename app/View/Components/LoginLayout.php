<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class LoginLayout extends Component
{
    public string $title = 'Magyar Kolónia Berlin e.V.';

    public function __construct(string $title)
    {
        $this->title = $title ? $title.' | Magyar Kolónia Berlin e.V.' : 'Magyar Kolónia Berlin e.V.';

    }

    public function render(): View
    {
        return view('layouts.login');
    }
}
