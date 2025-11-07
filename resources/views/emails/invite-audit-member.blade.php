<x-mails.header>

<x-slot name="header">
    {{ __('mails.invitation.greeting',[ 'name' => $member->first_name]) }}
</x-slot>

</x-mails.header>

<h2>{{ __('mails.audit_invitation.header') }}</h2>
<p>{{ __('mails.audit_invitation.text', ['range' => $accountReport->period_start->isoFormat('Do MMMM') . ' - '.$accountReport->period_end->isoFormat('Do MMMM')]) }}</p>

<br>
<x-mails.link-button href="{{ $url }}" >{{ __('mails.audit.invitation.link_label') }}</x-mails.link-button>

<x-mails.footer/>
