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
        <flux:table.columns>
            <flux:table.column>{{ __('members.widget.birthday.card.table.header.member') }}</flux:table.column>
            <flux:table.column>{{ __('members.widget.birthday.card.table.header.birthday') }}</flux:table.column>
            <flux:table.column class="hidden sm:table-cell"
                         align="right"
            >{{ __('members.widget.birthday.card.table.header.newage') }}</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($this->members as $member)
                <flux:table.row :key="$member->id">
                    <flux:table.cell class="flex items-center gap-3">
                        <span>
                            {{ \Illuminate\Support\Str::limit($member->name . ', '. $member->first_name,20) }}
                        </span>

                        @if($member->hasBirthdaytoday()) <x-ping/> @endif
                    </flux:table.cell>
                    <flux:table.cell class="whitespace-nowrap">{{ $member->birthDayInMonth() }}</flux:table.cell>
                    <flux:table.cell class=" hidden sm:table-cell"
                               align="end"
                    >
                        <flux:badge size="sm"
                                    color="lime"
                                    inset="top bottom"
                        >{{ $member->age() }}</flux:badge>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</flux:card>
