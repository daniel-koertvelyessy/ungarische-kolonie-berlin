<div>
    <flux:heading size="xl">{{ __('nav.tools') }}</flux:heading>
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-3 my-6">
        <flux:card>
            <flux:heading size="lg"
                          class="my-10"
            >{{ __('mails.members.heading') }}</flux:heading>
            <flux:text>{{ __('mails.members.content') }}</flux:text>

            @if($this->mailingList->count() >0)
            <flux:separator text="{{ __('mails.member.separator.options') }}" class="my-6"/>
            <div class="grid gap-3 lg:grid-cols-2">
                <flux:switch wire:model.live="include_mailing_list" label="Externe Mailingliste einschließen" />
                <div x-show="$wire.include_mailing_list" x-transition>
                    <flux:radio.group label="Grund des Schreibens" variant="cards" class="flex-col" wire:model="target_type" >
                        <flux:radio icon="calendar-days" value="standard" label="Neue Veranstaltung" />
                        <flux:radio icon="document-text" value="fast" label="Neuer Artikel" />
                        <flux:radio icon="cloud-arrow-up" value="next-day" label="Änderung Artikel/Veranstaltung" />
                    </flux:radio.group>
                </div>

            </div>
            @endif
            <flux:separator text="{{ __('mails.member.separator.text') }}" class="my-6"/>

            <form wire:submit="sendMembersMail"
                  class="space-y-6"
            >
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 my-3">
                    <section class="space-y-6">
                        <flux:subheading>Maygar szöveg</flux:subheading>

                        <flux:input label="Tárgy"
                                    wire:model="subject.hu"
                        />
                        <flux:textarea rows="auto"
                                       label="Üzenet"
                                       wire:model="message.hu"
                        />

                    </section>
                    <section class="space-y-6">
                        <flux:subheading>Deutscher Text</flux:subheading>
                        <flux:input label="Betreff"
                                    wire:model="subject.de"
                        />
                        <flux:textarea rows="auto"
                                       label="Nachricht"
                                       wire:model="message.de"
                        />

                    </section>
                </div>
                <flux:separator text="{{ __('mails.member.separator.links') }}" class="my-6"/>

                <flux:field>
                    <flux:label>Link</flux:label>

                    <flux:input.group>
                        <flux:input wire:model="url"
                                    placeholder="https://magyar-kolonia-berlin.org"
                        />
                    </flux:input.group>

                    <flux:error name="website"/>
                </flux:field>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
                    <section class="space-y-6">
                        <flux:input label="Maygar link szöveg"
                                    wire:model="url_label.hu"
                        />

                    </section>
                    <section class="space-y-6">
                        <flux:input label="Deutscher Link Label"
                                    wire:model="url_label.de"
                        />

                    </section>
                </div>

                <flux:separator text="{{ __('mails.member.separator.attachments') }}" class="my-6"/>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
                    <flux:field class="flex-col flex">
                        <flux:label>Csatolt fájl</flux:label>
                        <input type="file"
                               wire:model="attachments.hu"
                               accept=".pdf,.jpg,.jpeg,.png,.tif"
                               class="border border-zinc-300 p-1.5 rounded shadow-sm"
                        >
                        <flux:error name="attachments.hu"/>
                    </flux:field>

                    <flux:field class="flex-col flex">
                        <flux:label>Angehängte Datei</flux:label>
                        <input type="file"
                               wire:model="attachments.de"
                               accept=".pdf,.jpg,.jpeg,.png,.tif"
                               class="border border-zinc-300 p-1.5 rounded shadow-sm"
                        >
                        <flux:error name="attachments.de"/>
                    </flux:field>
                </div>


                @if(!app()->isProduction())
                    <flux:button wire:click="addDummyData">dummy</flux:button>
                @endif

                <flux:button href="{{ route('test-mail-preview', [
            'name' => 'Daniel',
            'subject' => $this->subject['de'] ?? 'Testbetreff',
            'message' => $this->message['de'] ?? 'Kein Inhalt???',
            'locale' => 'de',
            'url' => $this->url ?? 'www-popo',
            'url_label' => $this->url_label['de'] ?? 'nix label',
        ]) }}" target="_blank">{{ __('mails.members.btn.preview') }}</flux:button>

                <flux:button variant="primary"
                             wire:click="sendTestMailToSelf"
                >{{ __('mails.members.btn.test_mail') }}
                </flux:button>

                <flux:modal.trigger name="delete-profile">
                    <flux:button variant="danger">{{ __('mails.members.btn.submit') }}</flux:button>
                </flux:modal.trigger>

                <flux:modal name="delete-profile"
                            class="min-w-[22rem]"
                >
                    <div class="space-y-6">
                        <div>
                            <flux:heading size="lg">{{ __('mails.members.confirm.header') }}</flux:heading>

                            <flux:subheading>
                                <p>{{ __('mails.members.confirm.warning') }}</p>
                                <p>{{ __('mails.members.confirm.info') }}</p>
                            </flux:subheading>
                        </div>

                        <div class="flex gap-2">
                            <flux:spacer/>

                            <flux:modal.close>
                                <flux:button variant="ghost">{{ __('mails.members.btn.cancel') }}</flux:button>
                            </flux:modal.close>

                            <flux:button type="submit"
                                         variant="danger"
                                         icon-trailing="envelope"
                            >{{ __('mails.members.btn.final') }}
                            </flux:button>
                        </div>
                    </div>
                </flux:modal>


            </form>
        </flux:card>


        <flux:card>
            <flux:heading size="lg"
                          class="my-10"
            >{{ __('mails.mailing_list.verified_emails') }}</flux:heading>
            @if($this->mailingList->count() >0)
                <flux:table :paginate="$this->mailingList">
                    <flux:table.columns>
                        <flux:table.column sortable :sorted="$sortBy === 'mail'" :direction="$sortDirection" wire:click="sort('email')">E-Mail</flux:table.column>
                        <flux:table.column sortable :sorted="$sortBy === 'status'" :direction="$sortDirection" wire:click="sort('status')"><flux:icon.calendar-days class="size-4" /></flux:table.column>
                        <flux:table.column sortable :sorted="$sortBy === 'amount'" :direction="$sortDirection" wire:click="sort('amount')"><flux:icon.document-text class="size-4" /></flux:table.column>
                        <flux:table.column sortable :sorted="$sortBy === 'amount'" :direction="$sortDirection" wire:click="sort('amount')"><flux:icon.cloud-arrow-up class="size-4" /></flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        @foreach ($this->mailingList as $entry)
                            <flux:table.row :key="$entry->id">
                                <flux:table.cell class="flex items-center gap-3">
                                    <span class="text-wrap hyphens-auto">{{ $entry->email }}</span>
                                </flux:table.cell>
                                             <flux:table.cell>
                                    @if($entry->update_on_events)
                                        <flux:icon.check-circle color="green" class="size-4"/>
                                    @endif
                                </flux:table.cell>
                                <flux:table.cell>
                                    @if($entry->update_on_articles)
                                        <flux:icon.check-circle color="green" class="size-4"/>
                                    @endif
                                </flux:table.cell>
                                <flux:table.cell>
                                    @if($entry->update_on_notifications)
                                        <flux:icon.check-circle color="green" class="size-4"/>
                                    @endif
                                </flux:table.cell>
                            </flux:table.row>
                        @endforeach
                    </flux:table.rows>
                </flux:table>

            @else
            <flux:text>Keine verifizierten Einträge in der Mailingliste vorhanden</flux:text>
            @endif

        </flux:card>

    </section>
</div>
