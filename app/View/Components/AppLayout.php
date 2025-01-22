<?php

namespace App\View\Components;

use App\Models\Member;
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

    public function mount() {}

    public function render(): View
    {
        return view('layouts.app');
    }
}
