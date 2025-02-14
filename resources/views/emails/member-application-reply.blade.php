<x-mails.header header="{{ __('members.appliance_received.mail.subject') }}"/>

<h1>{{ __('members.appliance_received.mail.greeting',['name' => $member->first_name]) }}</h1>

<p>{{ __('members.appliance_received.mail.text') }}</p>
<br><br>

<x-mails.footer/>
