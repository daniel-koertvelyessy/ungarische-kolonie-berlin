@props([
    'meetingMinute' => null,
])

<div {{ $attributes->merge(['class' => 'space-y-6']) }}>
    @if($meetingMinute)
        <flux:heading size="lg">{{ $meetingMinute->title }}</flux:heading>

        <section class="space-y-3">
            <div class="flex items-center gap-3">
                <flux:label>{{ __('minutes.details.date') }}:</flux:label>
                <flux:text>{{ $meetingMinute->meeting_date->isoFormat('Do MMMM') }}</flux:text>
            </div>
            @if($meetingMinute->location)
                <div class="flex items-center gap-3">
                    <flux:label>{{ __('minutes.details.location') }}:</flux:label>
                    <flux:text>{{ $meetingMinute->location }}</flux:text>
                </div>
            @endif
            @if($meetingMinute->content)
                <div class="space-y-2">
                    <flux:label>{{ __('minutes.details.content') }}:</flux:label>
                    <flux:text class="prose prose-emerald prose-invert">{!! $meetingMinute->content !!}</flux:text>
                </div>
            @endif
        </section>

        <section class="space-y-3">
            <flux:heading size="md">{{ __('minutes.details.attendees') }}</flux:heading>
            @forelse($meetingMinute->attendees as $attendee)
                <div class="flex items-center gap-3">
                    <flux:text>{{ $attendee->name }}</flux:text>
                    @if($attendee->email)
                        <flux:text class="text-gray-500">({{ $attendee->email }})</flux:text>
                    @endif
                </div>
            @empty
                <flux:text>{{ __('minutes.details.no_attendees') }}</flux:text>
            @endforelse
        </section>

        <section class="space-y-3">
            <div class="space-y-2 ">
            <flux:heading size="md" class="col-span-3">{{ __('minutes.details.topics') }}</flux:heading>
            @forelse($meetingMinute->topics as $topic)

                <div class="grid lg:grid-cols-3 gap-4">
                    <flux:text class="prose-emerald prose-invert col-span-2">{!! $topic->content !!}</flux:text>
                    @if($topic->actionItems->isNotEmpty())
                        <div class="gap-4 col-span-1">
                            <flux:heading size="md">{{ __('minutes.details.action_items') }}:</flux:heading>
                            @foreach($topic->actionItems as $actionItem)
                                <aside>
                                    <div class="flex flex-col gap-3">
                                        <flux:text>{{ $actionItem->description }}</flux:text>
                                        @if($actionItem->assignee)
                                            <flux:text>
                                                {{ __('minutes.details.assigned_to') }}: {{ $actionItem->assignee->name }}
                                            </flux:text>
                                        @endif
                                        @if($actionItem->due_date)
                                            <flux:text>
                                                {{ __('minutes.details.due') }}: {{ $actionItem->due_date->format('Y-m-d') }}
                                            </flux:text>
                                        @endif
                                    </div>
                                </aside>
                            @endforeach
                        </div>
                    @endif
                </div>
                    @if(!$loop->last)
                        <flux:separator/>
                    @endif




            @empty
                <flux:text>{{ __('minutes.details.no_topics') }}</flux:text>
            @endforelse
            </div>
        </section>
    @else
        <flux:text>{{ __('minutes.details.select_meeting') }}</flux:text>
    @endif
</div>
