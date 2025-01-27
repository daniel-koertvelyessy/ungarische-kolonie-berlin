<div>

    <flux:main container
               class="space-y-2 lg:space-y-6"
    >
        <flux:heading size="xl">Antrag auf Mitgliedschaft in der Magyar Kolónia Berlin e. V.</flux:heading>
        <flex:text>Wir freuen uns, dass Sie Mitglied der Magyar Kolónia Berlin e. V. werden möchten. Die Aufnahme erfolgt nach dem unten stehenden Prozess:</flex:text>


        <section class="space-y-2 lg:space-y-6">
            <p><span class="font-semibold">Schritt 1</span> Füllen Sie als ersten Schritt das unten stehende Formular aus.</p>

            <div class="grid grid-cols-2">
                <div class="space-y-2">
                    <h3 class="font-semibold">Versand per Web</h3>

                    <p><span class="font-semibold">Schritt 2a:</span> Prüfen Sie die Angaben</p>
                    <p><span class="font-semibold">Schritt 3a:</span> Klicken Sie auf den Knopf <span class="text-sm text-emerald-600">{{ __('members.apply.checkAndSubmit') }}</span>.</p>
                    <p><span class="font-semibold">Schritt 4a:</span> Sie erhalten eine E-Mail vom System mit einem einmaligen Bestätigungslink.</p>
                    <p><span class="font-semibold">Schritt 5a:</span> Mit einem Klick auf diesen Link bestätigen Sie, dass die Anmeldung tatsächlich von Ihnen stammt.</p>

                    <div class="ml-6">
                        <p class="font-semibold text-lg">Wichtig!</p>
                        <p>Zum Versand über das Webprogramm muss Ihre E-Mail-Adresse angegeben werden. Wenn Sie keine E-Mail-Adresse besitzen, können Sie bei Schritt 2b weitermachen.</p>
                    </div>
                </div>
                <div class="space-y-2">
                    <h3 class="font-semibold">Versand per Post</h3>
                    <p><span class="font-semibold">Schritt 2b:</span> Prüfen Sie die Angaben</p>
                    <p><span class="font-semibold">Schritt 3b:</span> Klicken Sie auf das Kästchen <span class="text-sm text-emerald-600">{{ __('members.apply.email.none') }}</span>.</p>
                    <p><span class="font-semibold">Schritt 4b:</span> Klicken Sie auf den Knopf <span class="text-sm text-emerald-600">{{ __('members.apply.printAndSubmit') }}</span>, um eine PDF-Version des Formulars zu erstellen.</p>
                    <p><span class="font-semibold">Schritt 5b:</span> Drucken Sie das Formular aus, unterschreiben und senden Sie es an die im Formular angegebene Adresse.</p>
                </div>
            </div>


            <p><span class="font-semibold">Schritt 6</span> Wir prüfen Ihre Angaben und setzen uns persönlich in Verbindung, falls noch Informationen benötigt werden.</p>
            <p><span class="font-semibold">Schritt 7</span> Abschließend wird über Ihre Aufnahme im Leitungskreis entschieden und Sie auf dem ausgewählten Weg per E-Mail oder Post benachrichtigen.</p>
        </section>


        <form wire:submit="sendApplication">
            <div class="w-full lg:w-3/4 mx-auto">
                <flux:card class="space-y-6 mb-3 lg:mb-6">
                    <flux:separator text="Ich bin"/>
                    <flux:input wire:model="first_name"
                                label="Vorname"
                    />
                    <flux:input wire:model="name"
                                label="Nachname"
                                description="Erforderliches Feld"
                                required
                    />

                    <flux:input type="date"
                                wire:model="birth_date"
                                label="Geburtstag"
                    />

                    <flux:radio.group wire:model="gender"
                                      label="Geschlecht"
                                      variant="segmented"
                                      size="sm"
                    >
                        @foreach(\App\Enums\Gender::toArray() as $gender)
                            <flux:radio value="{{ $gender }}">{{ \App\Enums\Gender::value($gender) }}</flux:radio>
                        @endforeach

                    </flux:radio.group>

                    <flux:separator text="Anschrift"/>

                    <flux:textarea wire:model="address"
                                   label="Adresse"
                    />
                    <flux:input wire:model="city"
                                label="Stadt"
                    />
                    <flux:input wire:model="country"
                                label="Land"
                    />

                    <flux:separator text="Telefon"/>

                    <flux:input wire:model="phone"
                                label="Festnetz"
                    />
                    <flux:input wire:model="mobile"
                                label="Mobil"
                    />

                    <flux:separator text="Mitgliedsbeitrag"/>
                    <flux:text>Für zahlende Mitglieder wird ein Beitrag von {{ \App\Models\Member::feeForHumans() }} EUR pro Monat fällig. Mitglieder über 75 Jahre sind von Beizragszahlungen befreit.</flux:text>
                    <flux:checkbox wire:model="deduction"
                                   label="Ich beantrage einen reduzierten Mitgliedsbeitrag"
                    />
                    <flux:textarea wire:model="deduction_reason"
                                   label="Grund der Befreiung"
                    />

                    <flux:separator text="E-Mail"/>
                    <flux:text>{{ __('members.apply.email.benefits') }}</flux:text>

                    <flux:input wire:model="email"
                                label="E-Mail"
                    />

                    <flux:checkbox wire:model.live="nomail"
                                   label="{{ __('members.apply.email.none') }}"
                    />
                    @if($nomail)
                        <flux:text>{{ __('members.apply.email.without.text') }}</flux:text>
                    @endif
                </flux:card>
                {{--     <x-turnstile />--}}
                @if($nomail)
                    <flux:button type="button"
                                 variant="primary"
                                 icon="printer"
                    >{{ __('members.apply.printAndSubmit') }}</flux:button>
                @else
                    <flux:button type="submit"
                                 variant="primary"
                                 icon="paper-airplane"
                    >{{ __('members.apply.checkAndSubmit') }}</flux:button>
                @endif
            </div>


        </form>

    </flux:main>
</div>
