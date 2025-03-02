<?php

namespace App\Livewire\App\Global;

use Livewire\Component;

class DarkModeToggle extends Component
{
    public string $theme = 'system'; // Standardwert: 'system'

    public function mount()
    {
        $this->theme = session('theme', 'system');
    }

    public function setTheme(string $theme)
    {
        $this->theme = $theme;
        session(['theme' => $theme]);
        $this->dispatch('theme-changed', $theme);
    }

    public function render()
    {
        return view('livewire.app.global.dark-mode-toggle');
    }
}
