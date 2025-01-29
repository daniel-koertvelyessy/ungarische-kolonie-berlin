<div>

    <form wire:submit="updateEventData"

    >
        <section class="grid grid-cols-2 gap-3 mb-3">
            <flux:card class="col-span-1">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-3">
                    <flux:field class="space-y-6">
                        <flux:input type="date"
                                    wire:model="event_date"
                                    label="event_date"
                        />

                        <flux:input type="time"
                                    wire:model="start_time"
                                    label="start_time"
                        />

                        <flux:input type="time"
                                    wire:model="end_time"
                                    label="end_time"
                        />
                    </flux:field>

                    <flux:fieldset class="space-y-6">
                        <flux:field>
                            <flux:label>entry_fee</flux:label>
                            <flux:input.group>
                                <flux:input type="number" min="1" wire:model="entry_fee"
                                            placeholder="entry_fee"
                                />
                                <flux:input.group.suffix>EUR</flux:input.group.suffix>
                            </flux:input.group>
                            <flux:error name="entry_fee"/>
                        </flux:field>
                        <flux:field>
                            <flux:label>entry_fee_discounted</flux:label>
                            <flux:input.group>
                                <flux:input type="number" wire:model="entry_fee_discounted"
                                            placeholder="entry_fee_discounted"
                                />
                                <flux:input.group.suffix>EUR</flux:input.group.suffix>
                            </flux:input.group>
                            <flux:error name="entry_fee_discounted"/>
                        </flux:field>
                    </flux:fieldset>

                    <flux:field>
                        <flux:label>venue_id</flux:label>
                        <flux:select variant="listbox"
                                     searchable
                                     placeholder="Choose venue_id"
                                     wire:model="venue_id"
                        >
                            @forelse($this->venues as $key => $venue)
                                <flux:option value="{{ $venue->id }}"
                                             :key
                                >{{ $venue->name }}</flux:option>
                            @empty
                                <flux:option>Neu</flux:option>
                            @endforelse
                        </flux:select>
                    </flux:field>

                </div>

            </flux:card>

            <flux:card>
                <flux:input type="file" wire:model="logo" label="Logo" accept=".pdf,.jpg,.jpeg,.png,.webp"/>
            </flux:card>

            @foreach($locales as $locale)
                <flux:card class="space-y-6">
                    <flux:input wire:model="title.{{$locale}}"
                                label="title"
                                description="Der Titel wird für die Seite verwendet"
                    />
                    <flux:input wire:model="slug.{{$locale}}"
                                label="slug"
                                description="Der Slug wird als link Adresse bei der Erstellung generiert und darf nicht verändert werden."
                                readonly
                    />
                    <flux:editor wire:model="description.{{$locale}}"
                                 label="description"
                    />
                </flux:card>
            @endforeach
        </section>
       <flux:button type="submit" variant="primary">Speichern</flux:button>
    </form>
</div>
