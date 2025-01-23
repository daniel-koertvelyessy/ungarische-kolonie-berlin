<div class="space-y-6">

    <flux:heading size="xl">{{ __('members.show.title',['name' => $member->first_name . ' ' . $member->name]) }}</flux:heading>
    <flux:text size="sm">Erstellt am: {{ $member->created_at }} | Zuletzt bearbeitet am: {{ $member->updated_at }}</flux:text>


    <flux:tab.group>
        <flux:tabs>
            <flux:tab name="profile"
                      icon="user"
            >Profile
            </flux:tab>
            <flux:tab name="account"
                      icon="cog-6-tooth"
            >Account
            </flux:tab>
            <flux:tab name="billing"
                      icon="banknotes"
            >Billing
            </flux:tab>
        </flux:tabs>

        <flux:tab.panel name="profile">

            <form wire:submit="updateMember"
                  class="grid grid-cols-1 sm:grid-cols-2 gap-6"
            >

                <flux:card class="space-y-6">
                    <flux:input wire:model="first_name"
                                label="Vorname"
                    />
                    <flux:input wire:model="name"
                                label="Nachname"
                    />
                    <flux:textarea wire:model="address"
                                   label="Adresse"
                    />
                    <flux:input wire:model="city"
                                label="Stadt"
                    />
                    <flux:input wire:model="country"
                                label="Land"
                    />
                </flux:card>

                <flux:card class="space-y-6">
                    <flux:input wire:model="email"
                                label="E-Mail"
                    />
                    <flux:input wire:model="phone"
                                label="Festnetz"
                    />
                    <flux:input wire:model="mobile"
                                label="Mobil"
                    />

                    @if($user_id)
                        <flux:label>verknüft mit Benutzer {{ \App\Models\User::find($user_id)->username }}</flux:label>
                        <flux:button size="sm" square wire:click="detachUser($user_id)">
                            <flux:icon.trash variant="micro" class="text-red-500 dark:text-red-300" />
                        </flux:button>
                    @else

                        mit Konto verknüpfen

                    @endif

                </flux:card>
            </form>

        </flux:tab.panel>
        <flux:tab.panel name="account">
            <flux:card class="space-y-6">
                <flux:switch wire:model.live="is_discounted"
                             label="Ist rabattiert?"
                />
                <flux:input type="date"
                            wire:model="entered_at"
                            label="Eingetreten am"
                />
                <flux:input type="date"
                            wire:model="left_at"
                            label="Ausgetreten am"
                />

            </flux:card>


        </flux:tab.panel>
        <flux:tab.panel name="billing">

            Übersicht Zahlungen

            {{ $member }}
        </flux:tab.panel>
    </flux:tab.group>


</div>
