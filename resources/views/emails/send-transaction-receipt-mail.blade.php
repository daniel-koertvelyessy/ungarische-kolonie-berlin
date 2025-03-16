<x-mails.header>
    <x-slot name="icon">
        <svg width="140" height="140"
             xmlns="http://www.w3.org/2000/svg"
             fill="grey"
             stroke="none"
             viewBox="0 0 24 24"
        >
            <path d="M21 11h-3V4a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v14c0 1.654 1.346 3 3 3h14c1.654 0 3-1.346 3-3v-6a1 1 0 0 0-1-1zM5 19a1 1 0 0 1-1-1V5h12v13c0 .351.061.688.171 1H5zm15-1a1 1 0 0 1-2 0v-5h2v5z"></path>
            <path d="M6 7h8v2H6zm0 4h8v2H6zm5 4h3v2h-3z"></path>
        </svg>
    </x-slot>
</x-mails.header>

@if($member->gender === \App\Enums\Gender::fe->value)
    <h1>Sehr geehrte Frau {{ $member->name }},</h1>
@elseif($member->gender === \App\Enums\Gender::ma->value)
    <h1>Sehr geehrter Herr {{ $member->name }},</h1>
@else
    <h1>Szia {{ $member->fullName() }},</h1>
@endif


<p style="font-size: 14pt;">{{ __('Vielen Dank für Ihren Beitrag! Im Anhang finden Sie den Quittungsbeleg für Ihre Unterlagen. Bei Fragen gerne auf diese E-Mail antworten.') }}</p>


<p><strong>Übersicht</strong>
    <br>Zahlung erhalten am: <strong>{{ $transaction->date->locale(app()->getLocale())->isoFormat('Do MMMM YYYY') }}</strong>
    <br>Erhaltener Betrag: <span style="font-size: 8pt; font-weight: bold; margin-right: 3px">EUR</span> <strong>{{ $transaction->grossForHumans()  }}</strong>
    <br>Verwendungszwecks/Betreff <strong>{{ $transaction->label }}</strong>
    <br>Referenz: <strong>{{ $transaction->reference ?? '' }}</strong>
</p>


<br><br>


<x-mails.footer/>
