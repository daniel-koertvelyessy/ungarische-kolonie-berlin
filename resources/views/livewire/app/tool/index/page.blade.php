<div>
   <flux:heading size="xl">Werkzeuge</flux:heading>
    <h1 class="text-5xl !text-red-600">NICHT FERTIG :D</h1>
    <section class="grid grid-cols-2 gap-3 my-6">

        <flux:card>
            <flux:heading>email an alle mitglieder</flux:heading>
    <flux:separator text="texte"/>
            <form wire:submit="sendMembersMail" class="space-y-6">
                <div class="grid grid-cols-2 gap-3">
                    <section class="space-y-6">
                        <flux:subheading>Maygar szöveg</flux:subheading>

                        <flux:input label="Tárgy" wire:model="subject.hu" />
                        <flux:textarea rows="auto" label="Üzenet" wire:model="message.hu" />

                    </section>
                    <section class="space-y-6">
                        <flux:subheading>Deutscher Text</flux:subheading>
                        <flux:input label="Betreff" wire:model="subject.de" />
                        <flux:textarea rows="auto" label="Nachricht" wire:model="message.de" />

                    </section>
                </div>

                <flux:button type="submit" disabled variant="primary" icon-trailing="envelope">Absenden</flux:button>

            </form>
        </flux:card>

    </section>

</div>
