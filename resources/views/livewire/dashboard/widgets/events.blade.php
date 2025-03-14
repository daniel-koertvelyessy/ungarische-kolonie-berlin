
    <flux:card class="space-y-6">

        <flux:heading size="lg">{{ __('event.page.title') }}</flux:heading>

        <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="overflow-hidden rounded-lg bg-{{ \App\Enums\EventStatus::color(\App\Enums\EventStatus::DRAFT->value) }}-200 px-4 py-5 shadow-sm sm:p-6">
                <dt class="truncate text-sm font-medium text-gray-500">{{ \App\Enums\EventStatus::value(\App\Enums\EventStatus::DRAFT->value) }}</dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ $this->draftedEvents() }}</dd>
            </div>
            <div class="overflow-hidden rounded-lg bg-{{ \App\Enums\EventStatus::color(\App\Enums\EventStatus::PUBLISHED->value) }}-200 px-4 py-5 shadow-sm sm:p-6">
                <dt class="truncate text-sm font-medium text-gray-500">{{ \App\Enums\EventStatus::value(\App\Enums\EventStatus::PUBLISHED->value) }}</dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ $this->publishedEvents() }}</dd>
            </div>
            <div class="overflow-hidden rounded-lg bg-{{ \App\Enums\EventStatus::color(\App\Enums\EventStatus::PENDING->value) }}-100 px-4 py-5 shadow-sm sm:p-6 ">
                <dt class="truncate text-sm font-medium text-gray-500">{{ \App\Enums\EventStatus::value(\App\Enums\EventStatus::PENDING->value) }}</dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ $this->pendingEvents() }}</dd>
            </div>
        </dl>

    </flux:card>
