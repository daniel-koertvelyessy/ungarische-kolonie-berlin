<div class="p-3 border border-zinc-300 my-3 rounded-xl flex justify-between items-center">
    <div>
        <flux:heading>{{ $role->name[app()->getLocale()] }}</flux:heading>
        <flux:text>{{ $role->description }}</flux:text>

    </div>

    <aside class="flex flex-col gap-2">
        <flux:button size="xs"><flux:icon.pencil-square class="size-4" /></flux:button>
        <flux:button size="xs" wire:click="deleteRole({{ $role->id }})"><flux:icon.trash class="size-4" /></flux:button>
    </aside>

</div>
