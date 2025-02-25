<flux:card>
    <header class="flex items-center justify-between gap-3">
        <flux:button wire:click="previousMonth"
                     icon="arrow-left"
                     square
                     size="xs"
        ></flux:button>
        <flux:heading size="lg">{{ __('members.widget.birthday.card.heading', ['name' => $monthName]) }}</flux:heading>
        <flux:button wire:click="nextMonth"
                     icon="arrow-right"
                     square
                     size="xs"
        ></flux:button>
    </header>
    <flux:separator class="my-6"/>
    <flux:table :paginate="$this->members">
        <flux:columns>
            <flux:column>{{ __('members.widget.birthday.card.table.header.member') }}</flux:column>
            <flux:column>{{ __('members.widget.birthday.card.table.header.birthday') }}</flux:column>
            <flux:column class="hidden sm:table-cell"
                         align="right"
            >{{ __('members.widget.birthday.card.table.header.newage') }}</flux:column>
        </flux:columns>

        <flux:rows>
            @foreach ($this->members as $member)
                <flux:row :key="$member->id">
                    <flux:cell class="flex items-center gap-3">
                        <span>
                            {{ \Illuminate\Support\Str::limit($member->name . ', '. $member->first_name,20) }}
                        </span>

                        @if($member->hasBirthdayToday()) <x-ping/> @endif
                    </flux:cell>
                    <flux:cell class="whitespace-nowrap">{{ $member->birthDayInMonth() }}</flux:cell>
                    <flux:cell class=" hidden sm:table-cell"
                               align="end"
                    >
                        <flux:badge size="sm"
                                    color="lime"
                                    inset="top bottom"
                        >{{ $member->age() }}</flux:badge>
                    </flux:cell>
                </flux:row>
            @endforeach
        </flux:rows>
    </flux:table>
</flux:card>
