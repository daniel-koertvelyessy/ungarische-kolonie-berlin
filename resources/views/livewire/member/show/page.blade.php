<div class="space-y-6">

    <flux:heading size="xl">{{ __('members.show.title',['name' => $member->first_name . ' ' . $member->name]) }}</flux:heading>
    <flux:text size="sm">Erstellt am: {{ $member->created_at }} | Zuletzt bearbeitet am: {{ $member->updated_at }}</flux:text>

    <flux:tab.group>
        <flux:tabs>
            <flux:tab name="profile"
                      icon="user"
            >Angaben zur Person
            </flux:tab>
            <flux:tab name="account"
                      icon="cog-6-tooth"
            >Mitgliedschaft
            </flux:tab>
            <flux:tab name="billing"
                      icon="banknotes"
            >Beiträge
            </flux:tab>
        </flux:tabs>

        <flux:tab.panel name="profile">

            <section class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <form wire:submit="updateMemberData">
                    <flux:card class="space-y-6">
                        <flux:input wire:model="first_name"
                                    label="{{ __('members.first_name') }}"
                        />
                        <flux:input wire:model="name"
                                    label="{{ __('members.name') }}"
                        />
                        <flux:input type="date"
                                    wire:model="birth_date"
                                    label="Geboren am"
                        />
                        <flux:textarea wire:model="address"
                                       rows="auto"
                                       label="{{ __('members.address') }}"
                        />
                        <flux:input wire:model="zip"
                                    label="{{ __('members.zip') }}"
                                    class="w-24"
                        />
                        <flux:input wire:model="city"
                                    label="{{ __('members.city') }}"
                        />

                        <flux:input wire:model="country"
                                    label="{{ __('members.country') }}"
                        />
                        @can('update', $member)
                            <flux:button variant="primary"
                                         type="submit"
                            >Speichern
                            </flux:button>
                        @endcan
                    </flux:card>
                </form>

                <form wire:submit="updateContactData">
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
                        <flux:field>
                            @if($user_id)
                                <flux:label>verknüft mit Benutzer {{ \App\Models\User::find($user_id)->name }}</flux:label>
                                <flux:button size="sm"
                                             square
                                             wire:click="detachUser({{$user_id}})"
                                >
                                    <flux:icon.trash variant="micro"
                                                     class="text-red-500 dark:text-red-300"
                                    />
                                </flux:button>
                            @else
                                <flux:select variant="listbox"
                                             wire:model="newUser"
                                             searchable
                                             placeholder="{{ __('members.show.attached.placeholder') }}"
                                >
                                    <flux:option wire:key="0"
                                                 value="0"
                                    >Benutzer wählen
                                    </flux:option>
                                    @forelse($users as $user)
                                        <flux:option wire:key="{{ $user->id }}"
                                                     value="{{ $user->id }}"
                                        >{{ $user->name }}</flux:option>
                                    @empty
                                        <flux:option wire:key="0"
                                                     value="0"
                                        >Keine Benutzer gefunden
                                        </flux:option>

                                    @endforelse
                                </flux:select>
                                <flux:button size="sm"
                                             square
                                             wire:click="attachUser"
                                >
                                    <flux:icon.user-plus variant="micro"
                                                         class="text-emerald-500 dark:text-emerald-300"
                                    />
                                </flux:button>
                            @endif
                        </flux:field>
                        @can('update', $member)
                            <flux:spacer/>
                            <flux:button variant="primary"
                                         type="submit"
                            >Speichern
                            </flux:button>
                        @endcan
                    </flux:card>
                </form>
            </section>

        </flux:tab.panel>
        <flux:tab.panel name="account">
            <section class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <flux:card class="space-y-6">

                        <flux:field>
                            <flux:text>{{ __('members.date.applied_at') }} {{ $member->applied_at }}</flux:text>
                            <flux:heading size="lg">{{ $member->applied_at->diffForHumans() }}</flux:heading>
                        </flux:field>
                        <flux:field>
                        @if($member->verified_at)

                                <flux:text>{{ __('members.date.verified_at') }} {{ $member->verified_at }}</flux:text>
                                <flux:heading size="lg">{{ $member->verified_at->diffForHumans() }}</flux:heading>

                        @else
                            <flux:button variant="filled">{{ __('members.btn.sendVerificationMail.label') }}</flux:button>
                        @endif
                    </flux:field>
                        <flux:field>
                        @if($member->entered_at)

                                <flux:text>{{ __('members.date.entered_at') }} {{ $member->entered_at }}</flux:text>
                                <flux:heading size="lg">{{ $member->entered_at->diffForHumans() }}</flux:heading>

                        @else
                            <flux:button variant="primary">{{ __('members.btn.sendAcceptanceMail.label') }}</flux:button>
                        @endif
                    </flux:field>

                        <flux:field>
                        @if($member->left_at)

                                <flux:text>{{ __('members.date.left_at') }} {{ $member->left_at }}</flux:text>
                                <flux:heading size="lg">{{ $member->left_at->diffForHumans() }}</flux:heading>

                        @else
                            @if($member->entered_at)
                            @can('delete',$this->member)
                            <flux:button variant="danger">{{ __('members.btn.cancelMembership.label') }}</flux:button>
                            @endcan
                                    @endif

                        @endif
                    </flux:field>
                    </flux:card>

                <form wire:submit="updateMembershipData">
                    <flux:card class="space-y-6">
                        <flux:switch wire:model="is_deducted"
                                     label="Ist rabattiert?"
                        />
                        <flux:textarea wire:model="deduction_reason"
                                       rows="auto"
                        />

                    </flux:card>
                </form>

            </section>

        </flux:tab.panel>
        <flux:tab.panel name="billing">

            Übersicht Zahlungen

            {{ $member }}
        </flux:tab.panel>
    </flux:tab.group>


</div>
