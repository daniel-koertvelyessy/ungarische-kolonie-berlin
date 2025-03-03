<div class="flex items-center justify-start text-xs gap-3">
    <span>{{ App\Models\User::find($audit->user_id)->name }}</span>
    @if ($audit->is_approved)

        <span>
       <flux:icon.check-circle color="lime" class="size-4" />
        {{ $audit->approved_at }}
        </span>
    @else
               <flux:icon.x-circle color="zinc" class="size-4" />

        @if(Auth::user()->id === $audit->user_id)
            <flux:button href="{{ route('account-report.audit',$audit->id) }}" icon="document-check" size="xs" variant="primary">jetzt prüfen</flux:button>
        @endif

    @endif
    @if ($audit->reason)

        <flux:tooltip toggleable>
            <flux:button icon="document-text" size="xs" variant="ghost" />
            <flux:tooltip.content class="max-w-[20rem] space-y-2">
                <p>{{ $audit->reason }}</p>
            </flux:tooltip.content>
        </flux:tooltip>
    @endif


</div>



