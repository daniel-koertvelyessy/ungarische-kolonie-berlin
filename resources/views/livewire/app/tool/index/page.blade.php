<div>
    <flux:heading size="xl">{{ __('nav.tools') }}</flux:heading>
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-3 my-6">

        <flux:card>
            <flux:heading size="lg"
                          class="my-10"
            >{{ __('mails.members.heading') }}</flux:heading>
            <flux:text>{{ __('mails.members.content') }}</flux:text>
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
                        <flux:input.group.prefix>https://</flux:input.group.prefix>

                        <flux:input wire:model="url"
                                    placeholder="example.com"
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

                <flux:button wire:click="previewEMail">{{ __('mails.members.btn.preview') }}</flux:button>

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

    </section>

    @script
    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('open-email-preview', previewUrl => {
                window.open(previewUrl, '_blank');
            });
        });
    </script>
    @endscript

</div>
