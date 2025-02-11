<x-app-layout title="{{ __('nav.dashboard') }}">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6 lg:gap-9">
        <livewire:dashboard.widgets.applicants />
        <livewire:dashboard.widgets.events />
        <flux:card>
            <flux:heading size="lg">Kontostände</flux:heading>
            <x-balance-sheet/>
        </flux:card>
    </div>
</x-app-layout>
