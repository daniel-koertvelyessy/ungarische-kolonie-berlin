<x-app-layout title="{{ __('nav.dashboard') }}">
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3  gap-3 md:gap-6 lg:gap-9">
        <livewire:dashboard.widgets.applicants />
        <livewire:dashboard.widgets.events />
        <flux:card>
            <flux:heading size="lg">Kontostände</flux:heading>
            <x-balance-sheet/>
        </flux:card>
    </div>
</x-app-layout>
