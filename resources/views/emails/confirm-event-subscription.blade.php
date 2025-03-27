<x-mails.header url="{{ $confirmUrl }}">

    <x-slot name="icon">
        <svg xmlns="http://www.w3.org/2000/svg"
             fill="none"
             viewBox="0 0 24 24"
             stroke-width="1.5"
             stroke="currentColor"
             style="width: 300px; max-width: 600px; height: auto; margin: auto; display: block;"
        >
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M21.75 9v.906a2.25 2.25 0 0 1-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 0 0 1.183 1.981l6.478 3.488m8.839 2.51-4.66-2.51m0 0-1.023-.55a2.25 2.25 0 0 0-2.134 0l-1.022.55m0 0-4.661 2.51m16.5 1.615a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V8.844a2.25 2.25 0 0 1 1.183-1.981l7.5-4.039a2.25 2.25 0 0 1 2.134 0l7.5 4.039a2.25 2.25 0 0 1 1.183 1.98V19.5Z"
            />
        </svg>
    </x-slot>

    <x-slot name="header">
        {{ __('mails.invitation.greeting',[ 'name' => $subscription->name]) }}
    </x-slot>

</x-mails.header>

<p>Hallo & Szia {{ $subscription->name }},</p>
<p>{{ __('event.subscription.mail.text') }}</p>
<p>
<x-mails.link-button  href="{{ $confirmUrl }}" >{{ __('event.subscription.mail.link.label') }}</x-mails.link-button>
</p>

@if($subscription->brings_guests)
<p>{{ __('event.subscription.mail.bring_a_guest', ['num' => $subscription->amount_guests ]) }}</p>
@endif

@if($subscription->consentNotification)
<p>{{ __('event.subscription.mail.notification') }}.</p>
@endif

<p>{{ __('event.subscription.mail.ignore') }}<br>{{ __('event.subscription.disclaimer.body') }}</p>

<x-mails.footer/>
