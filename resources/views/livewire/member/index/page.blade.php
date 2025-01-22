<div>

    entered_at
    left_at
    is_discounted
    birth_date
    name
    first_name
    email
    phone
    mobile
    address
    city
    country
    gender
    type
    User

    <flux:heading size="xl">Übersicht der Mitglieder</flux:heading>
    <flux:table :paginate="$this->members">
        <flux:columns>
            <flux:column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection" wire:click="sort('name')">Name</flux:column>
            <flux:column sortable :sorted="$sortBy === 'mobile'" :direction="$sortDirection" wire:click="sort('mobile')" class="hidden sm:table-cell">Mobil</flux:column>
            <flux:column sortable :sorted="$sortBy === 'status'" :direction="$sortDirection" wire:click="sort('status')" class="hidden sm:table-cell">Status</flux:column>
            <flux:column sortable :sorted="$sortBy === 'birth_date'" :direction="$sortDirection" wire:click="sort('birth_date')" class="hidden sm:table-cell">Geburtstag</flux:column>
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
                        <flux:badge size="sm" :color="\App\Enums\MemberType::color($member->type)" inset="top bottom">{{ $member->type }}</flux:badge>
                    </flux:cell>

                    <flux:cell class=" hidden sm:table-cell" variant="strong">{{ $member->birth_date }}</flux:cell>

                    <flux:cell>
                        <flux:dropdown :key="$member->id">
                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>

                            <flux:menu>
                                <flux:menu.item icon="plus">New post</flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </flux:cell>
                </flux:row>
            @endforeach
        </flux:rows>
    </flux:table>
</div>
