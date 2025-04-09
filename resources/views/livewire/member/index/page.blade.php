<div class="space-y-6">

    <flux:heading size="xl">{{ __('members.title') }}</flux:heading>
    <flux:text>{{ __('members.header') }}</flux:text>

    <nav class="flex gap-2 items-center ">

        {{--        @if(\Illuminate\Support\Facades\Auth::user()->is_admin)
                    <flux:button href="{{ route('members.import') }}"
                                 size="sm"
                                 icon-trailing="arrow-down-on-square-stack"
                    ><span class="hidden lg:flex">Importieren</span>
                    </flux:button>
                    <flux:separator vertical/>

                @endif--}}


        <flux:input size="sm"
                    wire:model.live.debounce="search"
                    clearable
                    icon="magnifying-glass"
                    placeholder="Suche ..."
        />
        <flux:separator vertical/>

        <flux:checkbox.group wire:model.live="filteredBy"
                             class="hidden lg:flex lg:flex-row space-x-2"
        >
            @foreach(\App\Enums\MemberType::cases() as $type)
                <flux:checkbox label="{{ \App\Enums\MemberType::value($type->value) }}"
                               value="{{ $type->value }}"
                />
            @endforeach
        </flux:checkbox.group>


        <flux:select wire:model.live="filteredBy"
                     variant="listbox"
                     size="sm"
                     indicator="checkbox"
                     selected-suffix="Filter"
                     multiple
                     placeholder="Filter ..."
                     class=" lg:hidden"
        >
            @foreach(\App\Enums\MemberType::cases() as $type)
                <flux:select.option value="{{ $type->value }}">{{ \App\Enums\MemberType::value($type->value) }}</flux:select.option>
            @endforeach

        </flux:select>

        @can('create',App\Models\Membership\Member::class)
            <flux:separator vertical/>
            <flux:button href="{{ route('backend.members.create') }}"
                         size="sm"
                         variant="primary"
            >
                <flux:icon.user-plus class="size-4"/>
                <span class="hidden lg:flex">Neu anlegen</span>
            </flux:button>

        @endcan

    </nav>
    <flux:table :paginate="$this->members">
        <flux:table.columns>
            <flux:table.column sortable
                               :sorted="$sortBy === 'name'"
                               :direction="$sortDirection"
                               wire:click="sort('name')"
            >{{ __('members.table.header.name') }}</flux:table.column>
            <flux:table.column sortable
                               :sorted="$sortBy === 'mobile'"
                               :direction="$sortDirection"
                               wire:click="sort('mobile')"
                               class="hidden sm:table-cell"
            >{{ __('members.table.header.phone') }}</flux:table.column>
            <flux:table.column sortable
                               :sorted="$sortBy === 'status'"
                               :direction="$sortDirection"
                               wire:click="sort('status')"
                               class="hidden sm:table-cell"
            >{{ __('members.table.header.status') }}</flux:table.column>
            <flux:table.column class="hidden sm:table-cell"
            >{{ __('members.table.header.fee_status') }}</flux:table.column>
            <flux:table.column sortable
                               :sorted="$sortBy === 'birthdate'"
                               :direction="$sortDirection"
                               wire:click="sort('birth_date')"
                               class="hidden sm:table-cell"
            >{{ __('members.table.header.birthday') }}</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($this->members as $member)
                <flux:table.row :key="$member->id">
                    <flux:table.cell class="flex items-center gap-3">
                        {{ $member->first_name }}
                        {{ $member->name }}
                    </flux:table.cell>

                    <flux:table.cell class="whitespace-nowrap hidden sm:table-cell">{{ $member->mobile }}</flux:table.cell>
                    <flux:table.cell class=" hidden sm:table-cell">
                        <flux:badge size="sm"
                                    :color="\App\Enums\MemberType::color($member->type)"
                                    inset="top bottom"
                        >{{ \App\Enums\MemberType::value($member->type) }}</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell class=" hidden sm:table-cell">
                        @php
                            $fee_status = $member->feeStatus();
                        $color = $fee_status['status'] ? 'lime' : 'orange';
                        $paid = $member->fee_type === \App\Enums\MemberFeeType::FREE->value ? __('members.fee-type.free') :  $fee_status['paid'];
                        @endphp
                        <flux:badge size="sm"
                                    color="{{ $color }}"
                                    inset="top bottom"
                        >{{ $paid }}</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell class=" hidden sm:table-cell">
                        {{ optional($member->birth_date)->format('Y-m-d') }}
                    </flux:table.cell>

                    @can('view', App\Models\Membership\Member::class)
                        <flux:table.cell>
                            <flux:dropdown :key="$member->id">
                                <flux:button variant="ghost"
                                             size="sm"
                                             icon="ellipsis-horizontal"
                                             inset="top bottom"
                                ></flux:button>

                                <flux:menu>
                                    <flux:menu.item href="{{ route('backend.members.show',$member) }}"
                                                    icon="pencil"
                                    >{{ __('members.con.men.edit') }}</flux:menu.item>
                                    <flux:menu.item icon="currency-euro">{{ __('members.con.men.payment') }}</flux:menu.item>
                                    <flux:menu.item icon="trash">{{ __('members.con.men.delete') }}</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    @endcan
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>
