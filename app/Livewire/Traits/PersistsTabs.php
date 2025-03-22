<?php

namespace App\Livewire\Traits;

trait PersistsTabs
{
    public function setSelectedTab(string $tabName): void
    {
        $pageKey = $this->getTabSessionKey();
        session([$pageKey => $tabName]);
        $this->selectedTab = $tabName;
    }

    public function getSelectedTab(): string
    {
        $pageKey = $this->getTabSessionKey();

        return session($pageKey, $this->defaultTab ?? '');
    }

    private function getTabSessionKey(): string
    {
        // Unique session key based on the Livewire component name
        return 'selected_tab_'.static::class;
    }

    public function mount(): void
    {
        $this->selectedTab = $this->getSelectedTab();
    }
}
