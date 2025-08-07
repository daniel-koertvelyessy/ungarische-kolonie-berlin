<?php

declare(strict_types=1);

namespace App\Livewire\App\Global;

use Livewire\Component;

final class DarkModeToggle extends Component
{
    public string $theme = 'system'; // Standardwert: 'system'

    public function mount(): void
    {
        $this->theme = session('theme', 'system');
    }

    public function setTheme(string $theme): void
    {
        $this->theme = $theme;
        session(['theme' => $theme]);
        $this->dispatch('theme-changed', $theme);
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.app.global.dark-mode-toggle');
    }
}
