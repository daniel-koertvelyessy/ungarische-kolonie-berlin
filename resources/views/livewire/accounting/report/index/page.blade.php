@php use App\Models\Accounting\Account; @endphp
@php use App\Models\Membership\Member; @endphp
<div>
    <flux:heading size="lg">Monatsberichte</flux:heading>

    <flux:table :paginate="$this->reports">
        <flux:table.columns>
            <flux:table.column sortable
                               :sorted="$sortBy === 'account_id'"
                               :direction="$sortDirection"
                               wire:click="sort('account')"
            >{{ __('reports.table.header.name') }}</flux:table.column>
            <flux:table.column sortable
                               :sorted="$sortBy === 'created_at'"
                               :direction="$sortDirection"
                               wire:click="sort('created')"
                               class="hidden md:table-cell"
            >{{ __('reports.table.header.date') }}</flux:table.column>
            <flux:table.column sortable
                               :sorted="$sortBy === 'status'"
                               :direction="$sortDirection"
                               wire:click="sort('status')"
                               class="hidden md:table-cell"
            >{{ __('reports.table.header.status') }}</flux:table.column>
            <flux:table.column sortable
                               :sorted="$sortBy === 'period_start'"
                               :direction="$sortDirection"
                               wire:click="sort('range')"
                               class="hidden lg:table-cell"
            >{{ __('reports.table.header.range') }}</flux:table.column>
            <flux:table.column sortable
                               :sorted="$sortBy === 'audited'"
                               :direction="$sortDirection"
                               wire:click="sort('audited')"
                               class="hidden lg:table-cell"
            >{{ __('reports.table.header.audited') }}</flux:table.column>

        </flux:table.columns>

        <flux:table.rows>
            @foreach ($this->reports as $item)
                <flux:table.row :key="$item->id">
                    <flux:table.cell>
                        <span>{{ $item->account->name }}</span>
                        <aside class="lg:hidden space-y-3 mt-2">
                            @if($item->checkAuditStatus())
                                <span>Prüfer</span>
                                @foreach($item->getReportAudits() as $key => $audit)
                                    <x-table-cell-audit-item :audit="$audit"/>
                                @endforeach

                            @else
                                <flux:icon.x-circle color="orange"
                                                    class="size-5"
                                />
                            @endif
                        </aside>
                    </flux:table.cell>
                    <flux:table.cell class="hidden md:table-cell">
                        {{ $item->created_at }}
                    </flux:table.cell>
                    <flux:table.cell variant="strong"
                                     class="hidden md:table-cell"
                    >
                        {{ $item->status }}
                    </flux:table.cell>
                    <flux:table.cell class="hidden lg:table-cell">
                        {{ $item->period_start->format('Y') }} //
                        {{ $item->period_start->isoFormat('Do MMMM') }} -
                        {{ $item->period_end->isoFormat('Do MMMM') }}
                    </flux:table.cell>
                    <flux:table.cell class="hidden lg:table-cell space-y-3">
                        @if($item->checkAuditStatus())
                            @foreach($item->getReportAudits() as $key => $audit)
                                <x-table-cell-audit-item :audit="$audit"/>
                            @endforeach

                        @else
                            <flux:icon.x-circle color="orange"
                                                class="size-5"
                            />
                        @endif
                    </flux:table.cell>
                    @can('create', Account::class)
                        <flux:table.cell>
                            <flux:dropdown>
                                <flux:button variant="ghost"
                                             size="sm"
                                             icon="ellipsis-horizontal"
                                             inset="top bottom"
                                ></flux:button>

                                <flux:menu>
                                    <flux:menu.item icon="printer"
                                                    href="{{ route('accounts.report.print',$item->id) }}"
                                                    target="_blank"
                                    >{{ __('drucken') }}
                                    </flux:menu.item>
                                    <flux:menu.item icon="shield-check"
                                                    wire:click="initiateAudit({{ $item->id }})"
                                    >{{ __('prüfen') }}
                                    </flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    @endcan
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>


    <flux:modal name="initiate-report-audit"
                variant="flyout"
                position="right"
    >
        <form wire:submit="sendInvitations">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">{{ __('reports.initiate-report-audit-modal.title') }}</flux:heading>
                    <flux:text>{{ __('reports.initiate-report-audit-modal.content') }}</flux:text>
                </div>

                <flux:input.group>
                    <flux:select variant="listbox"
                                 searchable
                                 placeholder="Mitglied wählen"
                                 wire:model="selectedMember"
                    >
                        @foreach(Member::select()->get() as $member)
                            <flux:select.option value="{{ $member->id }}">{{ $member->fullName() }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:button icon-trailing="plus"
                                 wire:click="addAuditor"
                    >hinzu
                    </flux:button>
                </flux:input.group>


                <section class="space-y-6 px-3">
                    @forelse($auditorList as $key => $auditor)
                        <div class="flex justify-between items-center text-sm"
                             wire:key="{{$key}}"
                        >
                            <span>{{ $auditor->fullName() }}</span>
                            <flux:icon.trash color="red"
                                             class="size-4"
                                             wire:click="removeAuditor({{ $auditor->id }})"
                            />
                        </div>
                    @empty
                        <div class="flex justify-between items-center text-sm">
                            niemand
                        </div>
                    @endforelse
                </section>


                <div class="flex">
                    <flux:spacer/>

                    <flux:button type="submit"
                                 variant="primary"
                    >{{ __('reports.initiate-report-audit-modal.btn.submit') }}</flux:button>
                </div>
            </div>
        </form>
        <x-debug/>
    </flux:modal>
</div>
