
    <flux:card class="space-y-6">

        <flux:heading size="lg">{{ __('event.page.title') }}</flux:heading>

        <flux:subheading class="flex items-center justify-between">{{ \App\Enums\EventStatus::value(\App\Enums\EventStatus::DRAFT->value) }}
            <flux:badge color="{{ \App\Enums\EventStatus::color(\App\Enums\EventStatus::DRAFT->value) }}">{{ $this->draftedEvents() }}</flux:badge>
        </flux:subheading>

        <flux:subheading class="flex items-center justify-between">{{ \App\Enums\EventStatus::value(\App\Enums\EventStatus::PUBLISHED->value) }}
            <flux:badge color="{{ \App\Enums\EventStatus::color(\App\Enums\EventStatus::PUBLISHED->value) }}">{{ $this->publishedEvents() }}</flux:badge>
        </flux:subheading>
        <flux:subheading class="flex items-center justify-between">{{ \App\Enums\EventStatus::value(\App\Enums\EventStatus::PENDING->value) }}
            <flux:badge color="{{ \App\Enums\EventStatus::color(\App\Enums\EventStatus::PENDING->value) }}">{{ $this->pendingEvents() }}</flux:badge>
        </flux:subheading>

    </flux:card>
