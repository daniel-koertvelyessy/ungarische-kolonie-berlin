<x-mails.header>

<x-slot name="header">{{ $mail_subject }}</x-slot>

</x-mails.header>
@if($setPersonalGreeting)
<h2>{{ __('mails.invitation.greeting',[ 'name' => $mail_name]) }}</h2><br>
@endif
<p>{{ $mail_message }}</p>

@if($setLink && $url !=='')
    <x-mails.link-button href="{{ $url }}" >{{ $url_label }}</x-mails.link-button>
@endif



<x-mails.footer/>
