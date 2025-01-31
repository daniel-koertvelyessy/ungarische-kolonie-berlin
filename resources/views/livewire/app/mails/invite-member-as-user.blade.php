<div>
    @if(session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <flux:input type="email" wire:model="email" placeholder="User Email" />
    <flux:button type="button" wire:click="sendInvitation">Send Invitation</flux:button>
</div>
