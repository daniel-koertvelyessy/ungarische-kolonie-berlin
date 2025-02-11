<div class="space-y-6">

    <flux:heading size="xl">{{ __('members.title') }}</flux:heading>
    <flux:text>{{ __('members.header') }}</flux:text>
    <flux:table :paginate="$this->members">
        <flux:columns>
            <flux:column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection" wire:click="sort('name')">{{ __('members.table.header.name') }}</flux:column>
            <flux:column sortable :sorted="$sortBy === 'mobile'" :direction="$sortDirection" wire:click="sort('mobile')" class="hidden sm:table-cell">{{ __('members.table.header.phone') }}</flux:column>
            <flux:column sortable :sorted="$sortBy === 'type'" :direction="$sortDirection" wire:click="sort('type')" class="hidden sm:table-cell">{{ __('members.table.header.status') }}</flux:column>
            <flux:column sortable :sorted="$sortBy === 'birth_date'" :direction="$sortDirection" wire:click="sort('birthday')" class="hidden sm:table-cell">{{ __('members.table.header.birthday') }}</flux:column>
        </flux:columns>

        <flux:rows>
            @foreach ($this->members as $member)
                <flux:row :key="$member->id">
                    <flux:cell class="flex items-center gap-3">
                        {{ $member->first_name }}
                        {{ $member->name }}
                    </flux:cell>

                    <flux:cell class="whitespace-nowrap hidden sm:table-cell">{{ $member->mobile }}</flux:cell>
                    <flux:cell class=" hidden sm:table-cell">
                        <flux:badge size="sm" :color="\App\Enums\MemberType::color($member->type)" inset="top bottom">{{ \App\Enums\MemberType::value($member->type) }}</flux:badge>
                    </flux:cell>

                    <flux:cell class=" hidden sm:table-cell" variant="strong">{{ $member->birth_date }}</flux:cell>
                    @can('view', \App\Models\Membership\Member::class)
                    <flux:cell>
                        <flux:dropdown :key="$member->id">
                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>

                            <flux:menu>
                                <flux:menu.item href="{{ route('members.show',$member) }}" icon="pencil">{{ __('members.con.men.edit') }}</flux:menu.item>
                                <flux:menu.item icon="currency-euro">{{ __('members.con.men.payment') }}</flux:menu.item>
                                <flux:menu.item icon="trash">{{ __('members.con.men.delete') }}</flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </flux:cell>
                        @endcan
                </flux:row>
            @endforeach
        </flux:rows>
    </flux:table>
</div>
