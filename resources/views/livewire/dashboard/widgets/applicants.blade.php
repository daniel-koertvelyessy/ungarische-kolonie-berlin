<div>
    <flux:card class="space-y-6">
        @if($this->applicants->total()>0)
        <flux:heading size="lg">{{ __('members.widgets.applicants.title') }} <flux:badge color="lime" size="sm">{{ $this->applicants()->total() }}</flux:badge></flux:heading>

        <aside class="flex items-center gap-3">
            <flux:input icon="magnifying-glass"
                        placeholder="Search orders"
                        class="flex-1"
                        size="sm"
                        wire:model.live="search"
            />
            <flux:dropdown x-show="$wire.selectedApplicants.length > 0"
                           x-cloak
            >
                <flux:button icon="ellipsis-vertical"
                             size="sm"
                >Optionen
                </flux:button>
                <flux:menu>
                    <flux:menu.item icon="pencil">Bearbeiten</flux:menu.item>
                    <flux:menu.item variant="danger" wire:confirm="Wirklich?"
                                    icon="trash"
                                    wire:click="deleteSelectedApplicants"
                    >Delete
                    </flux:menu.item>
                </flux:menu>
            </flux:dropdown>
        </aside>


        <flux:table :paginate="$this->applicants">
            <flux:columns>
                <flux:column class="w-1/6">
                    <x-selectAllApplicants/>
                </flux:column>
                <flux:column sortable
                             :sorted="$sortBy === 'name'"
                             :direction="$sortDirection"
                             wire:click="sort('name')"
                >Name
                </flux:column>
                <flux:column sortable
                             :sorted="$sortBy === 'applied_at'"
                             :direction="$sortDirection"
                             wire:click="sort('applied_at')"
                >vom
                </flux:column>
            </flux:columns>

            <flux:rows>
                @foreach ($this->applicants as $applicant)
                    <flux:row :key="$applicant->id">
                        <flux:cell>
                            <flux:checkbox :value="$applicant->id"
                                           wire:model="selectedApplicants"
                            />
                        </flux:cell>
                        <flux:cell class="whitespace-nowrap">
                            {{ $applicant->name }}
                        </flux:cell>

                        <flux:cell>{{ $applicant->applied_at->diffForHumans() }}</flux:cell>

                    </flux:row>
                @endforeach
            </flux:rows>
        </flux:table>
        @else
            <flux:heading size="lg" class="my-36 justify-center flex gap-3">{{ __('members.widgets.applicants.title') }} <flux:badge color="zinc" size="sm">0</flux:badge></flux:heading>
        @endif

    </flux:card>

</div>
