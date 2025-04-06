<div>

    <flux:heading size="lg">Leitungsfunktion zuordnen</flux:heading>
    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <form wire:submit.prevent="save" class>
        <section class="space-y-6">

            <flux:field>
                <flux:label>Verfügbare Rollen</flux:label>
                <flux:button.group>
                    <flux:select wire:model.live="roleId"
                                 placeholder="Rolle zuordnen"
                    >
                        <flux:select.option value="new">{{ __('neue Rolle anlegen') }}</flux:select.option>

                        @foreach ($roles as $role)
                            <flux:select.option value="{{ $role->id }}">{{ $role->name }}</flux:select.option>
                        @endforeach
                    </flux:select.option>

                    <flux:modal.trigger name="make-new-role"
                                        x-show="$wire.roleId != 'new'"
                    >
                        <flux:button>Neue Rolle</flux:button>
                    </flux:modal.trigger>
                </flux:button.group>
                <flux:error name="roleId"/>
            </flux:field>


            <flux:field>
                <flux:label>Ernannt am</flux:label>
                <flux:date-picker wire:model="designatedAt"/>
                <flux:error name="designatedAt"/>
            </flux:field>

            <flux:separator text="öffentliche Daten" class="my-4" />

            <section class="grid gap-3 grid-cols-1 sm:grid-cols-2">

                <flux:textarea label="Über mich"
                               wire:model="aboutMe.de"
                ></flux:textarea>

                <flux:textarea label="Rolam"
                               wire:model="aboutMe.hu"
                ></flux:textarea>
            </section>

            <flux:input type="file"
                        wire:model="profileImage"
                        label="Profilbild"
            />

        </section>

        <flux:button variant="primary"
                     type="submit"
        >Assign Role
        </flux:button>
    </form>


    <flux:modal name="make-new-role">

        <flux:heading size="lg">Rolle zuordnen</flux:heading>


        <form wire:submit="addRole">

            <flux:input wire:model="role_name" label="name" />
            <flux:input wire:model="role_description" label="description" />
            <flux:input type="number" min="0" wire:model="role_sort" label="sort" />
            <flux:button variant="primary"
                         type="submit"
            >Assign Role
            </flux:button>

        </form>

    </flux:modal>
</div>
