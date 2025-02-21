<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{
    public string $title = 'Magyar Kolónia Berlin e.V.';

    public bool $is_login_page;

    public function __construct(string $title, ?bool $is_login_page)
    {
        $this->title = $title ? $title.' | Magyar Kolónia Berlin e.V.' : 'Magyar Kolónia Berlin e.V.';
        $this->is_login_page = filter_var($is_login_page, FILTER_VALIDATE_BOOLEAN);

        //        dd($is_login_page, gettype($is_login_page));

    }

    public function render(): View
    {
        return view('layouts.guest');
    }
}
