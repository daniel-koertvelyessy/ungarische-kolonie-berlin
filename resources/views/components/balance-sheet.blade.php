<section class="space-y-6 my-3 ">
    @php $total = 0; @endphp
    @forelse(\App\Models\Accounting\Account::select('id','name','starting_amount','updated_at')->get() as $account)
        @php
            $accountBalance=   $account->accountBalance();
            $total += $accountBalance;
        @endphp
        <flux:card class="flex items-center justify-between">
            <div>
                <flux:heading>{{ $account->name }}</flux:heading>
                <flux:text>Stand: {{ $account->updated_at->diffForHumans() }}</flux:text>
            </div>
            <aside class="font-bold {{ $total>0 ? 'text-emerald-600' : 'text-orange-600' }}"><span class="text-sm mr-2.5">EUR</span>  <span>{{ $total>0?'+': '-' }}</span>{{ number_format(($accountBalance/100),2,',','.') }}</aside>
        </flux:card>
    @empty

    @endforelse
    <aside class="flex pt-3 items-center border-t border-t-2 border-dashed">
<span>Gesamter Kontostand:</span>

        <flux:spacer/>
        <span class="text-sm mr-2.5">EUR</span>
        <span class="font-bold {{ $total>0 ? 'text-emerald-600' : 'text-orange-600' }}">
            {{ number_format(($total/100),2,',','.') }}
        </span>
    </aside>

</section>

