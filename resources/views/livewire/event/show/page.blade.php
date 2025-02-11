<div>

    <flux:heading size="xl"
                  class="mb-3 lg:mb-9"
    >{{ __('event.show.page.title',['name' => $form->title[app()->getLocale()]]) }}</flux:heading>

    <flux:tab.group>
        <flux:tabs wire:model="tab">
            <flux:tab name="descriptions">Texte</flux:tab>
            <flux:tab name="payments">Zahlungen</flux:tab>
        </flux:tabs>

        <flux:tab.panel name="descriptions">
            <form wire:submit="updateEventData"

            >
                <section class="grid grid-cols-1 lg:grid-cols-2 gap-3 mb-3">

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

                    <flux:card class="col-span-1">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-3">
                            <flux:field class="space-y-6">
                                <flux:input type="date"
                                            wire:model="form.event_date"
                                            label="{{__('event.form.event_date')}}"
                                />

                                <flux:input type="time"
                                            wire:model="form.start_time"
                                            label="{{__('event.form.start_time')}}"
                                />

                                <flux:input type="time"
                                            wire:model="form.end_time"
                                            label="{{__('event.form.end_time')}}"
                                />
                            </flux:field>

                            <flux:fieldset class="space-y-6">
                                <flux:field>
                                    <flux:label>{{__('event.form.status')}}</flux:label>
                                    <flux:select wire:model="form.status" variant="listbox" placeholder="Choose industry...">
                                        @foreach(\App\Enums\EventStatus::cases() as $status)
                                            <flux:option value="{{ $status->value }}">
                                                <flux:badge color="{{ \App\Enums\EventStatus::color($status->value) }}">{{ \App\Enums\EventStatus::value($status->value) }}</flux:badge>
                                            </flux:option>
                                        @endforeach

                                    </flux:select>
                                </flux:field>

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
                            </flux:fieldset>

                            <flux:field class="col-span-3">
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

                        </div>

                    </flux:card>

                    <flux:card class="space-y-3">
                        <flux:heading>{{ __('event.form.image.upload') }}</flux:heading>
                        @if($form->event->image)
                            <img src="{{ asset('storage/images/'.$form->event->image) }}"
                                 alt=""
                                 class="my-3 lg:my-9 rounded-md shadow"
                            >
                            @can('update',\App\Models\Event::class)
                            <flux:button size="sm"
                                         variant="danger"
                                         icon="trash"
                                         wire:click="deleteImage"
                            />
                                @endcan
                        @else
                            @can('update',\App\Models\Event::class)
                            <livewire:app.global.image-upload/>
                                @endcan
                        @endif
                    </flux:card>


                </section>
                @can('update',\App\Models\Event::class)
                <flux:button type="submit"
                             variant="primary"
                >Speichern
                </flux:button>
                    @endcan
            </form>
        </flux:tab.panel>
        <flux:tab.panel name="payments">
            <flux:table :paginate="$this->payments">
                <flux:columns>
                    <flux:column>Text</flux:column>
                    <flux:column sortable :sorted="$sortBy === 'date'" :direction="$sortDirection" wire:click="sort('date')">Datum</flux:column>
                    <flux:column sortable :sorted="$sortBy === 'member_id'" :direction="$sortDirection" wire:click="sort('member')">Mitglied</flux:column>
                    <flux:column sortable :sorted="$sortBy === 'amount'" :direction="$sortDirection" wire:click="sort('amount')" align="right">Betrag</flux:column>
                </flux:columns>
@php $total = 0; @endphp
                <flux:rows>
                    @foreach ($this->payments as $payment)
                        <flux:row :key="$payment->id">

                            <flux:cell variant="strong">
                                {{ $payment->label }}
                                {{ \App\Enums\TransactionType::calc($payment->transaction->type) }}
                            </flux:cell>

                            <flux:cell>{{ $payment->date->diffForHumans() }}</flux:cell>
                            <flux:cell>{{ $payment->name }}</flux:cell>

                            <flux:cell variant="strong" align="end">
                                <span class="text-{{ \App\Enums\TransactionType::color($payment->transaction->type) }}-600">
                                    {{ $payment->amountForHumans() }}
                                </span>
                            </flux:cell>

                        </flux:row>
                        @php $total += $payment->amount * \App\Enums\TransactionType::calc($payment->transaction->type); @endphp


                    @endforeach
                </flux:rows>
            </flux:table>
            <aside class="flex">
                <flux:spacer />
                <flux:heading size="lg">Ergebnis: <span class="mr-2.5 text-sm">EUR</span> <span class="{{ $total>0?'text-emerald-600':'text-orange-600' }}">{{ number_format(($total/100),2,',','.') }}</span></flux:heading>
            </aside>

            @can('create',\App\Models\Event::class)
                <aside class="mt-3 lg:mt-9">
                    <flux:modal.trigger name="add-new-payment" >
                        <flux:button variant="primary">Neue Zahlung erfassen</flux:button>
                    </flux:modal.trigger>
                </aside>
                @endcan
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


        <livewire:event.show.event-payment :event="$form->event" />

    </flux:modal>
</div>
