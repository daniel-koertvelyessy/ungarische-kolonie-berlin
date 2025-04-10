<x-app-layout title="{{ __('nav.dashboard') }}">
    <div class="columns space-y-4 lg:columns-2 2xl:columns-3">
        <livewire:dashboard.widgets.events />
        <flux:card class="break-inside-avoid">
            <flux:heading size="lg">Kontostände</flux:heading>
            <x-balance-sheet/>
        </flux:card>
        <livewire:dashboard.widgets.upcomming-birthday-list />
        <livewire:dashboard.widgets.applicants />
    </div>
</x-app-layout>
