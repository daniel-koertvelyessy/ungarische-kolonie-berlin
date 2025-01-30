<div>
    <form wire:submit="storeVenue">
        <section class="space-y-6" x-data="{ showGeoText: false}">
            <flux:input wire:model="form.name"
                        label="{{__('venue.name')}}"
            />
            <flux:input wire:model="form.address"
                        label="{{__('venue.address')}}"
            />
            <flux:input wire:model="form.postal_code"
                        label="{{__('venue.postal_code')}}"
            />
            <flux:input wire:model="form.city"
                        label="{{__('venue.city')}}"
            />
            <flux:input wire:model="form.country"
                        label="{{__('venue.country')}}"
            />
            <flux:input wire:model="form.phone"
                        label="{{__('venue.phone')}}"
            />
            <flux:input wire:model="form.website"
                        label="{{__('venue.website')}}"
            />
            <flux:field>
                <flux:label>
                    {{__('venue.geolocation')}}

                    <flux:button size="xs" variant="ghost" @click="showGeoText = !showGeoText">mehr</flux:button>
                </flux:label>
                <flux:input wire:model="form.geolocation"/>
            </flux:field>

            <aside class="p-2 border rounded-md w-72" x-cloak x-show="showGeoText">
                <flux:heading>Google Plus Code</flux:heading>
                <p class="text-sm">Die Eingabe des Codes in Google Maps führt einen Zeiger auf den Ort, um eine Navigation starten zu können.</p>
            </aside>

        </section>

        <footer>
            <flux:spacer/>
            <div class="flex pt-3 justify-between items-center">

                <flux:button type="button"

                             size="sm"
                >Nur speichern
                </flux:button>
                <flux:button type="submit"
                             size="sm"
                             variant="primary"
                >Speichern + Übernehmen
                </flux:button>
            </div>
        </footer>

    </form>
</div>
