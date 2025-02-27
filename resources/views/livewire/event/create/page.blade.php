<div>

    <flux:heading size="xl"
                  class="mb-3 lg:mb-9"
    >{{ __('event.create.page.title') }}</flux:heading>


    <form wire:submit="createEventData"

    >
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-3 mb-3">
            <flux:card class="col-span-1">
                <flux:input wire:model="form.name" label="{{ __('event.name') }}" class="mb-3" />
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
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
                            <flux:label>{{__('event.form.entry_fee')}}</flux:label>
                            <flux:input.group>
                                <flux:input type="number"
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

                        <flux:input wire:model="form.payment_link" label="{{ __('event.form.payment_link') }}" />
                    </flux:fieldset>

                    <section class="space-y-6">
                        <flex:field class="space-y-2">
                            <flux:label>{{__('event.form.venue_id')}}</flux:label>

                            <flux:select variant="listbox"
                                         searchable
                                         placeholder="Choose venue_id"
                                         wire:model="form.venue_id"
                            >
                                <flux:select.option value="new">Neu</flux:select.option>
                                @foreach($this->venues as $key => $venue)
                                    <flux:select.option value="{{ $venue->id }}"
                                                 :key
                                    >{{ $venue->name }}</flux:select.option>
                                @endforeach

                            </flux:select>

                            <div x-show="$wire.form.venue_id ==='new'"
                                 class="pt-3"
                            >
                                <flux:modal.trigger name="add-new-venue">
                                    <flux:button>{{ __('venue.new.btn.label') }}</flux:button>
                                </flux:modal.trigger>
                            </div>
                        </flex:field>

                        <flux:field >
                            <flux:label>{{__('event.type.label')}}</flux:label>
                            <flux:select variant="listbox"
                                         placeholder="Choose venue_id"
                                         wire:model="form.status"
                            >
                                @foreach(\App\Enums\EventStatus::cases() as $key => $status)
                                    <flux:select.option value="{{ $status->value }}"
                                                 :key
                                    ><flux:badge color="{{ \App\Enums\EventStatus::color($status->value) }}">{{ \App\Enums\EventStatus::value($status->value) }}</flux:badge></flux:select.option>
                                @endforeach

                            </flux:select>
                        </flux:field>

                    </section>

                </div>

            </flux:card>

            <flux:card class="space-y-3">
                <flux:heading>{{ __('event.form.image.upload') }}</flux:heading>

                <livewire:app.global.image-upload/>

            </flux:card>

            @foreach(\App\Enums\Locale::cases() as $locale)
                <flux:card class="space-y-6">

                    <flux:field>
                        <flux:label>Titel für Sprache
                            <flux:badge color="lime">{{ $locale->value }}</flux:badge>
                        </flux:label>
                        <flux:input wire:model="form.title.{{$locale->value}}"
                                    description="Der Titel wird für die Seite verwendet"
                        />
                        <flux:error name="form.title"/>
                    </flux:field>

                    <div>
                        <flux:label>Slug für Sprache
                            <flux:badge color="lime">{{ $locale->value }}</flux:badge>
                        </flux:label>

                        <flux:input wire:model="form.slug.{{$locale->value}}"
                                    description="{{ __('event.create.slug.notice') }}"
                        />
                        <flux:error name="form.slug"/>

                    </div>

                    <flux:field>
                        <flux:label>Text Auszug für Sprache
                            <flux:badge color="lime">{{ $locale->value }}</flux:badge>
                        </flux:label>
                        <flux:description>Wird für die Vorschau verwendet. Bitte max 200 Zeichen</flux:description>
                        <flux:editor class="**:data-[slot=content]:min-h-[100px]"
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
        <flux:button type="submit"
                     variant="primary"
        >Speichern
        </flux:button>
    </form>


    <flux:modal name="add-new-venue"
                variant="flyout"
                position="right"
                class="space-y-6"
    >
        <flux:heading size="lg">{{ __('venue.new.btn.label') }}</flux:heading>

        <livewire:venue.create.page/>

    </flux:modal>


</div>
