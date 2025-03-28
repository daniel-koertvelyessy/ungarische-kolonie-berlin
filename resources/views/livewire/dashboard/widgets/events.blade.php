@php use App\Enums\EventStatus; @endphp

<flux:card class="space-y-6 break-inside-avoid">

    <flux:heading size="lg">{{ __('event.page.title') }}</flux:heading>

    <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
        <div class="overflow-hidden rounded-lg bg-slate-100 px-4 py-5 shadow-sm sm:p-6">
            <dt class="truncate text-sm font-medium text-gray-500">{{ EventStatus::value(EventStatus::DRAFT->value) }}</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ $this->draftedEvents() }}</dd>
        </div>
        <div class="overflow-hidden rounded-lg bg-lime-100 px-4 py-5 shadow-sm sm:p-6">
            <dt class="truncate text-sm font-medium text-gray-500">{{ EventStatus::value(EventStatus::PUBLISHED->value) }}</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ $this->publishedEvents() }}</dd>
        </div>
        <div class="overflow-hidden rounded-lg bg-blue-100 px-4 py-5 shadow-sm sm:p-6 ">
            <dt class="truncate text-sm font-medium text-gray-500">{{ EventStatus::value(EventStatus::PENDING->value) }}</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ $this->pendingEvents() }}</dd>
        </div>
    </dl>

</flux:card>
