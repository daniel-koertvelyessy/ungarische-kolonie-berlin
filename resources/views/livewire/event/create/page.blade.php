<div>

    <flux:heading size="xl"
                  class="mb-3 lg:mb-9"
    >{{ __('event.create.page.title') }}</flux:heading>
    <!-- Progress Bar -->
    <nav aria-label="Progress"
         class="mb-3"
    >
        <ol role="list"
            class="space-y-4 md:flex md:space-y-0 md:space-x-8"
        >
            <li class="md:flex-1">
                <a href="#"
                   wire:click="setStep(1)"
                   class="group flex flex-col border-l-4 {{ $step >= 1 ? 'border-emerald-600 hover:border-emerald-800' : 'border-gray-200 hover:border-gray-300' }} py-2 pl-4 md:border-t-4 md:border-l-0 md:pt-4 md:pb-0 md:pl-0" {{ $step === 1 ? 'aria-current=step' : '' }}>
                    <span class="text-sm font-medium {{ $step >= 1 ? 'text-emerald-600 group-hover:text-emerald-800' : 'text-gray-500 group-hover:text-gray-700' }}">Step 1</span>
                    <span class="text-sm font-medium">Event Details</span>
                </a>
            </li>
            <li class="md:flex-1">
                <a href="#"
                   wire:click="setStep(2)"
                   class="group flex flex-col border-l-4 {{ $step >= 2 ? 'border-emerald-600 hover:border-emerald-800' : 'border-gray-200 hover:border-gray-300' }} py-2 pl-4 md:border-t-4 md:border-l-0 md:pt-4 md:pb-0 md:pl-0" {{ $step === 2 ? 'aria-current=step' : '' }}>
                    <span class="text-sm font-medium {{ $step >= 2 ? 'text-emerald-600 group-hover:text-emerald-800' : 'text-gray-500 group-hover:text-gray-700' }}">Step 2</span>
                    <span class="text-sm font-medium">Dates</span>
                </a>
            </li>
            <li class="md:flex-1">
                <a href="#"
                   wire:click="setStep(3)"
                   class="group flex flex-col border-l-4 {{ $step >= 3 ? 'border-emerald-600 hover:border-emerald-800' : 'border-gray-200 hover:border-gray-300' }} py-2 pl-4 md:border-t-4 md:border-l-0 md:pt-4 md:pb-0 md:pl-0" {{ $step === 3 ? 'aria-current=step' : '' }}>
                    <span class="text-sm font-medium {{ $step >= 3 ? 'text-emerald-600 group-hover:text-emerald-800' : 'text-gray-500 group-hover:text-gray-700' }}">Step 3</span>
                    <span class="text-sm font-medium">Images</span>
                </a>
            </li>
        </ol>
    </nav>

    <form wire:submit="createEventData"

    >
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-3 mb-3">
            @if ($step == 1)
                <flux:card class="col-span-1">
                    <flux:input wire:model="form.name"
                                label="{{ __('event.form.name') }}"
                                class="mb-3"
                    />
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
                        <flux:fieldset class="space-y-6">
                            <flux:date-picker wire:model="form.event_date"
                                              with-today
                                              selectable-header
                                              fixed-weeks
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
                        </flux:fieldset>

                        <flux:fieldset class="space-y-6">
                            <flux:field>
                                <flux:label>{{__('event.form.entry_fee')}}</flux:label>
                                <flux:input.group>
                                    <flux:input type="number"
                                                wire:model="form.entry_fee"
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
                                    />
                                    <flux:input.group.suffix>EUR</flux:input.group.suffix>
                                </flux:input.group>
                                <flux:error name="entry_fee_discounted"/>
                            </flux:field>

                            <flux:input wire:model="form.payment_link"
                                        label="{{ __('event.form.payment_link') }}"
                            />
                        </flux:fieldset>

                        <section class="space-y-6">
                            <flex:field class="space-y-2">
                                <flux:label>{{__('event.form.venue_id')}}</flux:label>

                                <flux:select variant="listbox"
                                             searchable
                                             placeholder="{{ __('event.form.venue.select') }}"
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

                            <flux:field>
                                <flux:label>{{__('event.type.label')}}</flux:label>
                                <flux:select variant="listbox"
                                             placeholder="Choose venue_id"
                                             wire:model="form.status"
                                >
                                    @foreach(App\Enums\EventStatus::cases() as $key => $status)
                                        <flux:select.option value="{{ $status->value }}"
                                                            :key
                                        >
                                            <flux:badge color="{{ App\Enums\EventStatus::color($status->value) }}">{{ App\Enums\EventStatus::value($status->value) }}</flux:badge>
                                        </flux:select.option>
                                    @endforeach

                                </flux:select>
                            </flux:field>

                        </section>

                    </div>

                </flux:card>
            @endif

            @if($step===2)
                @foreach(\App\Enums\Locale::cases() as $locale)
                    <flux:card class="space-y-6">

                        <flux:field>
                            <flux:label><span class="mr-1">Titel für Sprache</span>
                                <flux:badge color="lime"
                                            size="sm"
                                >{{ $locale->value }}</flux:badge>
                            </flux:label>
                            <x-input-with-counter
                                model="form.title.{{ $locale->value }}"
                                max-length="60"
                            />
                            <flux:error name="form.title"/>
                        </flux:field>

                        <flux:field>
                            <flux:label>
                                <span class="mr-1">Inhalt/Beschreibung für Sprache</span>
                                <flux:badge color="lime"
                                            size="sm"
                                >{{ $locale->value }}</flux:badge>
                            </flux:label>
                            <flux:editor wire:model="form.description.{{$locale->value}}"/>
                        </flux:field>

                    </flux:card>
                @endforeach

            @endif
            @if($step===3)
                <section class="col-span-2">
                    <flux:button size="sm"
                                 wire:click="makeWebText"
                                 variant="primary"
                                 icon-trailing="document"
                    >{{ __('event.backend.text-nav.btn-make-web-texts') }}</flux:button>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 mt-3">
                        @foreach(\App\Enums\Locale::cases() as $locale)
                            <flux:card class="space-y-6">

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

                            </flux:card>
                        @endforeach
                    </div>
                </section>

                <flux:card class="space-y-3">
                    <flux:heading>{{ __('event.form.image.upload') }}</flux:heading>

                    <livewire:app.global.image-upload/>
                </flux:card>
            @endif

        </section>


        <div class="mt-6 flex justify-between">
            @if ($step > 1)
                <flux:button type="button"
                             wire:click="previousStep"
                             variant="filled"
                >{!!  __('pagination.previous') !!}</flux:button>
            @else
                <span></span>
            @endif
            @if ($step < $totalSteps)
                <flux:button type="button"
                             wire:click="nextStep"
                             variant="primary"
                >{!! __('pagination.next') !!}</flux:button>
            @else
                <flux:button type="submit"
                             variant="primary"
                >Speichern
                </flux:button>
            @endif
        </div>
    </form>

    @if(!app()->isProduction())

        <x-debug/>

        <flux:button wire:click="addDemoData" variant="ghost">Demo Daten einfügen</flux:button>

    @endif

    @can('create', \App\Models\Event\Event::class)
        <flux:modal name="add-new-venue"
                    variant="flyout"
                    position="right"
                    class="space-y-6"
        >
            <flux:heading size="lg">{{ __('venue.new.btn.label') }}</flux:heading>

            <livewire:venue.create.page/>

        </flux:modal>
    @endcan


</div>
