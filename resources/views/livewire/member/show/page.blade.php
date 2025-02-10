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
                        <flux:input wire:model="memberForm.first_name"
                                    label="{{ __('members.first_name') }}"
                        />
                        <flux:input wire:model="memberForm.name"
                                    label="{{ __('members.name') }}"
                        />
                        <flux:input type="date"
                                    wire:model="memberForm.birth_date"
                                    label="Geboren am"
                        />
                        <flux:textarea wire:model="memberForm.address"
                                       rows="auto"
                                       label="{{ __('members.address') }}"
                        />
                        <flux:input wire:model="memberForm.zip"
                                    label="{{ __('members.zip') }}"
                                    class="w-24"
                        />
                        <flux:input wire:model="memberForm.city"
                                    label="{{ __('members.city') }}"
                        />

                        <flux:input wire:model="memberForm.country"
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
                        <flux:input wire:model="memberForm.email"
                                    label="E-Mail"
                        />
                        <flux:input wire:model="memberForm.phone"
                                    label="{{ __('members.phone') }}"
                                    mask="+99 99 99999999"
                                    placeholder="+49 30 12345678"
                                    autocomplete="tel"
                        />
                        <flux:input wire:model="memberForm.mobile"
                                    label="{{ __('members.mobile') }}"
                                    mask="+99 999 99999999"
                                    placeholder="+49 173 12345678"
                                    autocomplete="tel"
                        />

                        @can('update', $member)
                            <flux:field class="flex flex-col space-y-3">
                                @if($memberForm->user_id)
                                    <flux:label>verknüft mit Benutzer</flux:label>
                                    <flux:badge color="lime"
                                                size="lg"
                                    >{{ $memberForm->linked_user_name }}</flux:badge>
                                    <flux:button size="sm"
                                                 variant="danger"
                                                 wire:click="detachUser({{$memberForm->user_id}})"
                                    >{{ __('members.unlink_user') }}

                                    </flux:button>
                                @else
                                    <flux:button.group>
                                        <flux:select variant="listbox"
                                                     wire:model="memberForm.newUser"
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
                                        <flux:button square
                                                     wire:click="attachUser"
                                        >
                                            <flux:icon.user-plus variant="micro"
                                                                 class="text-emerald-500 dark:text-emerald-300"
                                            />
                                        </flux:button>
                                    </flux:button.group>
                                @endif
                            </flux:field>

                        @else

                            <flux:field>
                                <flux:label>{{ __('members.linked_user') }}</flux:label>
                                <flux:badge size="lg"
                                            color="lime"
                                > {{ $linked_user_name }}</flux:badge>
                            </flux:field>
                        @endcan


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

                <form wire:submit="updateMembershipData">

                    <flux:card class="space-y-6">

                        @can('update', $member)
                            <flux:radio.group wire:model="memberForm.type"
                                              label="{{ __('members.type') }}"
                                              variant="cards"
                                              class="max-sm:flex-col"
                            >

                                @foreach(\App\Enums\MemberType::cases() as $key => $type)
                                    <flux:radio value="{{ $type->value }}"
                                                label="{{ \App\Enums\MemberType::value($type->value) }}"
                                    />
                                @endforeach
                            </flux:radio.group>
                        @else
                            <flux:field>
                                <flux:label>{{ __('members.type') }}</flux:label>
                                <flux:badge size="lg"
                                            color=" {{ \App\Enums\MemberType::color($member_type) }}"
                                > {{ \App\Enums\MemberType::value($member_type) }}</flux:badge>
                            </flux:field>
                        @endcan


                        <flux:switch wire:model="memberForm.is_deducted"
                                     label="Ist rabattiert?"
                        />
                        <flux:textarea wire:model="memberForm.deduction_reason"
                                       rows="auto"
                        />
                            <flux:spacer/>
                            <flux:button variant="primary"
                                         type="submit"
                            >Speichern
                            </flux:button>
                    </flux:card>
                </form>

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

                    <flux:field class="space-y-2">
                        @if($member->left_at)

                           <div>
                               <flux:text>{{ __('members.date.left_at') }} {{ $member->left_at }}</flux:text>
                               <flux:heading size="lg">{{ $member->left_at->diffForHumans() }}</flux:heading>
                           </div>

                            @can('delete',$this->member)
                                <flux:button variant="primary" wire:click="reactivateMembership">Reaktivieren</flux:button>
                            @endcan
                        @else
                            @if($member->entered_at)
                                @can('delete',$this->member)
                                    <flux:button variant="danger" wire:click="cancelMember">{{ __('members.btn.cancelMembership.label') }}</flux:button>

                                @endcan
                            @endif

                        @endif


                    </flux:field>

                    @if(! $memberForm->user_id)
                        <flux:field>
                            <flux:button type="button"
                                         wire:click="sendInvitation"
                            >{{ __('members.btn.inviteAsUser.label') }}
                            </flux:button>
                            <flux:error for="email" />
                        </flux:field>
                    @endif
                </flux:card>


            </section>

        </flux:tab.panel>
        <flux:tab.panel name="billing">

            Übersicht Zahlungen

            {{ $member }}
        </flux:tab.panel>
    </flux:tab.group>


    <flux:modal name="delete-membership">
        <form wire:submit="deleteMembershipForSure" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('members.cancel.modal.title') }}</flux:heading>

                <flux:subheading>
                    <p>{{ __('members.cancel.modal.text') }}</p>
                </flux:subheading>
            </div>

            <div>
                <flux:input wire:model.live="confirm_deletion_text" label="{{ __('members.cancel.confirm_text_input.label') }}" />
            </div>

            @if($memberForm->user_id)
                Nutzer löschen!
                @endif

            <div class="flex gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button variant="ghost">{{ __('profile.2FA.modal-confirm.btn.cancel.label') }}</flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="danger" :disabled="$confirm_deletion_text !== $memberForm->name">{{ __('members.cancel.btn.final.label') }}</flux:button>
            </div>
        </form>
    </flux:modal>

</div>
