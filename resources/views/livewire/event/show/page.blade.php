<div>
    <flux:heading class="lg:mb-9 lg:hidden"
                  size="lg"
    >{{ __('event.show.page.title') }}</flux:heading>
    <flux:heading class="lg:mb-9 lg:flex hidden">{{ __('event.show.page.title') }}</flux:heading>
    <flux:subheading size="xl">{{ $form->name ?? $form->title[app()->getLocale()] }}</flux:subheading>


    <flux:tab.group class="mt-3">
        <flux:tabs wire:model="selectedTab">
            <flux:tab name="event-show-dates"
                      icon="calendar-days"
                      wire:click="setSelectedTab('event-show-dates')"
            ><span class="hidden md:inline">{{ __('event.tabs.nav.dates') }}</span></flux:tab>
            <flux:tab name="event-show-descriptions"
                      icon="document-text"
                      wire:click="setSelectedTab('event-show-descriptions')"
            ><span class="hidden md:inline">{{ __('event.tabs.nav.texts') }}</span></flux:tab>
            <flux:tab name="event-show-payments"
                      icon="banknotes"
                      wire:click="setSelectedTab('event-show-payments')"
            ><span class="hidden md:inline">{{ __('event.tabs.nav.payments') }}</span></flux:tab>
            <flux:tab name="event-show-subscriptions"
                      icon="chat-bubble-left-ellipsis"
                      wire:click="setSelectedTab('event-show-subscriptions')"
            ><span class="hidden md:inline">{{ __('event.tabs.nav.subscriptions') }}</span></flux:tab>
            <flux:tab name="event-show-visitors"
                      icon="users"
                      wire:click="setSelectedTab('event-show-visitors')"
            ><span class="hidden md:inline">{{ __('event.tabs.nav.visitors') }}</span></flux:tab>
            <flux:tab name="event-show-planing"
                      icon="queue-list"
                      wire:click="setSelectedTab('event-show-planing')"
            ><span class="hidden md:inline">{{ __('event.tabs.nav.planing') }}</span></flux:tab>
        </flux:tabs>

        <flux:tab.panel name="event-show-dates">
            <form wire:submit="updateEventData">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-3"
                >
                    <section class="space-y-6">

                        <flux:input wire:model="form.name"
                                    label="{{ __('event.name') }}"
                        />


                        <flux:input type="date"
                                    wire:model="form.event_date"
                                    label="{{__('event.form.event_date')}}"
                        />

                        <section class="grid grid-cols-1 lg:grid-cols-2 gap-3 lg:gap-9">
                            <flux:input type="time"
                                        wire:model="form.start_time"
                                        label="{{__('event.form.start_time')}}"
                            />

                            <flux:input type="time"
                                        wire:model="form.end_time"
                                        label="{{__('event.form.end_time')}}"
                            />
                        </section>

                        <flux:field>
                            <flux:label>{{__('event.form.venue_id')}}</flux:label>

                            <flux:select variant="listbox"
                                         searchable
                                         placeholder="Choose venue_id"
                                         wire:model="form.venue_id"
                            >
                                <flux:option value="new">Neu</flux:option>
                                @foreach($this->venues as $key => $venue)
                                    <flux:option value="{{ $venue->id }}"
                                                 :key
                                    >{{ $venue->name }}</flux:option>
                                @endforeach

                            </flux:select>

                            <div x-show="$wire.form.venue_id ==='new'"
                                 class="pt-3"
                            >
                                <flux:modal.trigger name="add-new-venue">
                                    <flux:button>{{ __('venue.new.btn.label') }}</flux:button>
                                </flux:modal.trigger>
                            </div>
                        </flux:field>

                        <flux:select wire:model="form.status"
                                     variant="listbox"
                                     placeholder="Choose industry..."
                                     label="{{__('event.form.status')}}"
                        >
                            @foreach(\App\Enums\EventStatus::cases() as $status)
                                <flux:option value="{{ $status }}">
                                    <flux:badge color="{{ \App\Enums\EventStatus::color($status->value) }}">{{ \App\Enums\EventStatus::value($status->value) }}</flux:badge>
                                </flux:option>
                            @endforeach
                        </flux:select>


                    </section>

                    <section class="space-y-6">

                        <flux:field>
                            <flux:label>{{__('event.form.entry_fee')}}</flux:label>
                            <flux:input.group>
                                <flux:input type="number"
                                            min="1"
                                            wire:model="form.entry_fee"
                                            placeholder="entry_fee"
                                />
                                <flux:input.group.suffix>EUR</flux:input.group.suffix>
                            </flux:input.group>
                            <flux:error name="entry_fee"/>
                        </flux:field>
                        <flux:field>
                            <flux:label>{{__('event.form.entry_fee_discounted')}}</flux:label>
                            <flux:input.group>
                                <flux:input type="number"
                                            wire:model="form.entry_fee_discounted"
                                            placeholder="entry_fee_discounted"
                                />
                                <flux:input.group.suffix>EUR</flux:input.group.suffix>
                            </flux:input.group>
                            <flux:error name="entry_fee_discounted"/>
                        </flux:field>


                        <flux:input wire:model="form.payment_link"
                                    label="{{ __('event.form.payment_link') }}"
                        />

                        <flux:separator text="{{ __('event.form.image.upload') }}"/>
                        @if($form->event->image)
                            <img src="{{ asset('storage/images/'.$form->event->image) }}"
                                 alt=""
                                 class="my-3 lg:my-9 rounded-md shadow"
                            >
                            @can('update',\App\Models\Event\Event::class)
                                <flux:button size="sm"
                                             variant="danger"
                                             icon="trash"
                                             wire:click="deleteImage"
                                />
                            @endcan
                        @else
                            @can('update',\App\Models\Event\Event::class)
                                <livewire:app.global.image-upload/>
                            @endcan
                        @endif
                    </section>
                </div>


                @can('update',\App\Models\Event\Event::class)
                    <flux:button type="submit"
                                 variant="primary"
                    >Speichern
                    </flux:button>
                @endcan

            </form>  <!-- END PANEL EVENT DATA -->
        </flux:tab.panel>

        <flux:tab.panel name="event-show-descriptions">
            <form wire:submit="updateEventData">

                <section class="grid grid-cols-1 lg:grid-cols-2 gap-3 mb-3"
                >
                    @foreach($form->locales as $locale)
                        <flux:card class="space-y-6">

                            <flux:field>
                                <flux:label>Titel für Sprache
                                    <flux:badge color="lime">{{ $locale->value }}</flux:badge>
                                </flux:label>
                                <flux:input wire:model="form.title.{{$locale->value}}"
                                            description="Der Titel wird für die Seite verwendet"
                                />
                            </flux:field>

                            {{--           <div>
                                           <flux:label>Slug für Sprache <flux:badge color="lime">{{ $locale->value }}</flux:badge> </flux:label>
                                           <br>
                                           <flex:text>{{ $form->slug[$locale->value] }}</flex:text>
                                       </div>--}}

                            <flux:field>
                                <flux:label>Text Auszug für Sprache
                                    <flux:badge color="lime">{{ $locale->value }}</flux:badge>
                                </flux:label>
                                <flux:description>Wird für die Vorschau verwendet. Bitte max 200 Zeichen</flux:description>
                                <flux:editor class="[&_[data-slot=content]]:min-h-[100px]"
                                             wire:model="form.excerpt.{{$locale->value}}"
                                />
                            </flux:field>

                            <flux:field>
                                <flux:label>Inhalt/Beschreibung für Sprache
                                    <flux:badge color="lime">{{ $locale->value }}</flux:badge>
                                </flux:label>
                                <flux:editor wire:model="form.description.{{$locale->value}}"/>
                            </flux:field>

                        </flux:card>
                    @endforeach
                </section>


                @can('update',\App\Models\Event\Event::class)
                    <flux:button type="submit"
                                 variant="primary"
                    >Speichern
                    </flux:button>
                @endcan
            </form>
        </flux:tab.panel>

        <flux:tab.panel name="event-show-subscriptions">
            <flux:table :paginate="$this->subscriptions">
                <flux:columns>
                    <flux:column>Name</flux:column>
                    <flux:column sortable
                                 :sorted="$sortBy === 'date'"
                                 :direction="$sortDirection"
                                 wire:click="sort('date')"
                    >Datum
                    </flux:column>
                    <flux:column sortable
                                 :sorted="$sortBy === 'status'"
                                 :direction="$sortDirection"
                                 wire:click="sort('status')"
                    >E-Mail
                    </flux:column>
                    <flux:column sortable
                                 :sorted="$sortBy === 'amount'"
                                 :direction="$sortDirection"
                                 wire:click="sort('amount')"
                    >Benachritigungen
                    </flux:column>
                    <flux:column sortable
                                 :sorted="$sortBy === 'amount'"
                                 :direction="$sortDirection"
                                 wire:click="sort('amount')"
                    >Telefon
                    </flux:column>
                    <flux:column sortable
                                 :sorted="$sortBy === 'amount'"
                                 :direction="$sortDirection"
                                 wire:click="sort('amount')"
                    ># Gäste
                    </flux:column>
                    <flux:column sortable
                                 :sorted="$sortBy === 'amount'"
                                 :direction="$sortDirection"
                                 wire:click="sort('amount')"
                    >E-Mail bestätigt am
                    </flux:column>
                </flux:columns>

                <flux:rows>
                    @forelse ($this->subscriptions as $subscription)
                        <flux:row :key="$subscription->id">
                            <flux:cell>
                                {{ $subscription->name }}
                            </flux:cell>
                            <flux:cell>
                                {{ $subscription->created_at->diffForHumans() }}
                            </flux:cell>
                            <flux:cell>
                                {{ $subscription->email }}
                            </flux:cell>
                            <flux:cell>
                                @if($subscription->consentNotification)
                                    <flux:icon.check-circle class="size-4 text-lime-700"/>
                                @else
                                    <flux:icon.minus-circle class="size-4 text-orange-700"/>
                                @endif
                            </flux:cell>
                            <flux:cell>
                                {{ $subscription->phone }}
                            </flux:cell>
                            <flux:cell>
                                {{ $subscription->amount_guests }}
                            </flux:cell>
                            <flux:cell>
                                {{ optional($subscription->confirmed_at)->diffForHumans() }}
                            </flux:cell>


                        </flux:row>
                    @empty

                    @endforelse
                </flux:rows>
            </flux:table>


        </flux:tab.panel>

        <flux:tab.panel name="event-show-payments">
            <flux:table :paginate="$this->payments">
                <flux:columns>
                    <flux:column>Text</flux:column>
                    <flux:column sortable
                                 :sorted="$sortBy === 'date'"
                                 :direction="$sortDirection"
                                 wire:click="sort('date')"
                    >Datum
                    </flux:column>
                    <flux:column sortable
                                 :sorted="$sortBy === 'member_id'"
                                 :direction="$sortDirection"
                                 wire:click="sort('member')"
                    >Besucher
                    </flux:column>
                    <flux:column sortable
                                 :sorted="$sortBy === 'amount'"
                                 :direction="$sortDirection"
                                 wire:click="sort('amount')"
                                 align="right"
                    >Betrag
                    </flux:column>
                </flux:columns>
                <flux:rows>
                    @foreach ($this->payments as $payment)

                        <flux:row :key="$payment->transaction->id">

                            <flux:cell variant="strong">
                                {{ $payment->transaction->label }}
                            </flux:cell>

                            <flux:cell>{{ $payment->transaction->date->diffForHumans() }}</flux:cell>
                            <flux:cell>{{ $payment->visitor_name }}</flux:cell>

                            <flux:cell variant="strong"
                                       align="end"
                            >
                                <span class="text-{{ \App\Enums\TransactionType::color($payment->transaction->type) }}-600">
                                    {{ $payment->transaction->grossForHumans() }}
                                </span>
                            </flux:cell>

                        </flux:row>

                    @endforeach
                </flux:rows>
            </flux:table>

            @can('create',\App\Models\Event\Event::class)
                <aside class="mt-3 lg:mt-9">
                    <flux:modal.trigger name="add-new-payment">
                        <flux:button variant="primary">Neue Zahlung erfassen</flux:button>
                    </flux:modal.trigger>

                    <flux:button href="{{ route('backend.events.report', $event) }}"
                                 wire:click="generateEventReport"
                    >Bericht erstellen
                    </flux:button>
                </aside>
            @endcan
        </flux:tab.panel>

        <flux:tab.panel name="event-show-visitors">

            <nav class="mb-10 justify-between flex items-center">

                @can('create', \App\Models\Event\Event::class)
                    <flux:button wire:click="addVisitor"
                                 variant="primary"
                                 icon-trailing="user-plus"
                    >{{ __('event.visitor.btn.add.label') }}</flux:button>
                @endcan


            </nav>


            <flux:table :paginate="$this->visitors">
                <flux:columns>
                    <flux:column sortable
                                 :sorted="$sortBy === 'name'"
                                 :direction="$sortDirection"
                                 wire:click="sort('name')"
                    >{{ __('event.visitor-table.header.name') }}
                    </flux:column>
                    <flux:column sortable
                                 :sorted="$sortBy === 'email'"
                                 :direction="$sortDirection"
                                 wire:click="sort('email')"
                                 class="hidden md:table-cell"
                    >{{ __('event.visitor-table.header.email') }}
                    </flux:column>

                    <flux:column sortable
                                 :sorted="$sortBy === 'member_id'"
                                 :direction="$sortDirection"
                                 wire:click="sort('is_member')"
                                 class="hidden md:table-cell"
                    >{{ __('event.visitor-table.header.is_member') }}
                    </flux:column>
                    <flux:column sortable
                                 :sorted="$sortBy === 'subscription_id'"
                                 :direction="$sortDirection"
                                 wire:click="sort('is_subscriber')"
                                 class="hidden md:table-cell"
                    >{{ __('event.visitor-table.header.is_subscriber') }}
                    </flux:column>
                </flux:columns>
                <flux:rows>
                    @forelse ($this->visitors as $visitor)

                        <flux:row :key="$visitor->id">
                            <flux:cell variant="strong">
                                {{ $visitor->name }}
                            </flux:cell>
                            <flux:cell class="hidden md:table-cell">
                                {{ $visitor->email }}
                            </flux:cell>
                            <flux:cell class="hidden md:table-cell">
                                @if($visitor->member_id)
                                    <flux:icon.user-circle size="4"/>
                                @endif
                            </flux:cell>
                            <flux:cell class="hidden md:table-cell">
                                @if($visitor->event_subscription_id)
                                    <flux:icon.chat-bubble-left-ellipsis size="4"/>
                                @endif
                            </flux:cell>

                        </flux:row>

                    @empty
                        <flux:row>
                            <flux:cell variant="strong">
                                {{ __('event.visitors.empty_results_msg') }}
                            </flux:cell>
                        </flux:row>
                    @endforelse
                </flux:rows>
            </flux:table>
        </flux:tab.panel>

        <flux:tab.panel name="event-show-planing">
            <section class="grid grid-cols-1 gap-3 lg:gap-6 lg:grid-cols-2">
                <flux:card>

                    <header class="flex justify-between items-center mb-3 lg:mb-6">
                        <flux:heading size="lg">{{ __('event.assignments.heading') }}</flux:heading>

                        <flux:modal.trigger name="assignment-modal">
                            <flux:button size="sm"
                                         icon-trailing="plus"
                            >neue Aufgabe
                            </flux:button>
                        </flux:modal.trigger>
                    </header>

                    <flux:table :paginate="$this->assignments">
                        <flux:columns>
                            <flux:column sortable
                                         :sorted="$sortBy === 'task'"
                                         :direction="$sortDirection"
                                         wire:click="sort('task')"
                            >{{ __('assignment.table.header.task') }}</flux:column>
                            <flux:column sortable
                                         :sorted="$sortBy === 'member_id'"
                                         :direction="$sortDirection"
                                         wire:click="sort('member')"
                                         class="hidden sm:table-cell"
                            >{{ __('assignment.table.header.lead') }}</flux:column>
                            <flux:column sortable
                                         :sorted="$sortBy === 'status'"
                                         :direction="$sortDirection"
                                         wire:click="sort('status')"
                            >{{ __('assignment.table.header.status') }}</flux:column>
                            <flux:column sortable
                                         :sorted="$sortBy === 'due_at'"
                                         :direction="$sortDirection"
                                         wire:click="sort('due_at')"
                                         class="hidden sm:table-cell"
                            >{{ __('assignment.table.header.due_at')}}</flux:column>
                            <flux:column sortable
                                         :sorted="$sortBy === 'amount'"
                                         :direction="$sortDirection"
                                         wire:click="sort('amount')"
                                         class="hidden sm:table-cell"
                                         align="right"
                            >{{ __('assignment.table.header.amount')}}</flux:column>
                        </flux:columns>
                        <flux:rows>
                            @forelse ($this->assignments as $assignment)
                                <flux:row :key="$event->id">
                                    <flux:cell variant="strong" class="flex items-center gap-2">
                                        {{ $assignment->task }}
                                        @if($assignment->description)
                                            <flux:tooltip toggleable>
                                                <flux:button icon="document-text" size="xs" variant="ghost" />

                                                <flux:tooltip.content class="max-w-[20rem] space-y-2">
                                                    {{ $assignment->description }}
                                                </flux:tooltip.content>
                                            </flux:tooltip>
                                        @endif
                                    </flux:cell>
                                    <flux:cell class="hidden sm:table-cell">
                                        {{ $assignment->member->fullName() }}
                                    </flux:cell>
                                    <flux:cell>
                                        <flux:badge color="{{ $assignment->statusColor() }}" size="sm">{{ $assignment->statusLabel() }}</flux:badge>
                                    </flux:cell>
                                    <flux:cell class="hidden sm:table-cell">
                                        {{ $assignment->getDueString() }}
                                    </flux:cell>
                                    <flux:cell class="hidden sm:table-cell" align="end">
                                        {{ $assignment->amountString() }}
                                    </flux:cell>
                                </flux:row>
                            @empty
                                <flux:row>
                                    <flux:cell colspan="3">Keine Aufgaben</flux:cell>
                                </flux:row>
                            @endforelse
                        </flux:rows>
                    </flux:table>


                </flux:card>
                <flux:card>
                    <flux:heading>{{ __('event.timeline.heading') }}</flux:heading>
                    start
                    ende
                    Title
                    Verantwortlich
                    Notes
                </flux:card>
            </section>
        </flux:tab.panel>
    </flux:tab.group>


    <flux:modal name="add-new-venue"
                variant="flyout"
                position="right"
                class="space-y-6"
    >
        <flux:heading size="lg">{{ __('venue.new.btn.label') }}</flux:heading>

        <livewire:venue.create.page/>

    </flux:modal>

    <flux:modal name="add-new-payment"
                variant="flyout"
                position="right"
                class="space-y-6"
    >


        <livewire:accounting.transaction.create.form :event="$form->event"/>

    </flux:modal>

    <flux:modal name="add-new-visitor"
                variant="flyout"
                position="right"
                class="space-y-6"
    >


        <livewire:event.visitor.create.form :event="$form->event"/>

    </flux:modal>

    <flux:modal name="assignment-modal"
                class="md:w-96 space-y-6"
                variant="flyout"
                position="right"
    >

        <form wire:submit="addAssignment">
            <section class="space-y-6">
                <flux:heading size="lg">{{ __('assignment.modal.heading') }}</flux:heading>
                <flux:select wire:model="assignmentForm.member_id"
                             variant="listbox"
                             searchable
                             label="{{__('assignment.lead')}}"
                >
                    @foreach(\App\Models\Membership\Member::select('id', 'name', 'first_name')->get() as $member)
                        <flux:option value="{{ $member->id }}">{{ $member->fullName() }}</flux:option>
                    @endforeach
                </flux:select>
                <flux:input wire:model="assignmentForm.task"
                            label="{{__('assignment.task')}}"
                />
                <flux:select wire:model="assignmentForm.status"
                             label="{{__('assignment.status')}}"
                >
                    @foreach(\App\Enums\AssignmentStatus::cases() as $status)
                        <flux:option value="{{$status->value}}">{{ \App\Enums\AssignmentStatus::value($status->value) }}</flux:option>
                    @endforeach
                </flux:select>

                <flux:textarea rows="auto"
                               wire:model="assignmentForm.description"
                               label="{{__('assignment.description')}}"
                />
                <flux:input type="date"
                            wire:model="assignmentForm.due_at"
                            label="{{__('assignment.due_at')}}"
                />

                <flux:field>
                    <flux:label>{{__('assignment.amount')}}</flux:label>

                    <flux:input.group>
                        <flux:input type="number" wire:model="assignmentForm.amount"
                        />
                        <flux:input.group.suffix>EUR</flux:input.group.suffix>
                    </flux:input.group>
                    <flux:error name="assignmentForm.amount"/>
                </flux:field>

                <flux:button type="submit"
                             variant="primary"
                >{{ __('assignment.btn.submit.label') }}
                </flux:button>

            </section>
        </form>


    </flux:modal>
</div>
