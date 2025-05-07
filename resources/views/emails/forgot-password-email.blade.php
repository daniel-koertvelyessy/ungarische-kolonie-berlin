<x-mails.header title="{{ __('Reset Password Notification') }}" />

<h1>{{ __('Hello!') }}</h1>

<p>{{ __('You are receiving this email because we received a password reset request for your account.') }}</p>
<p>{{ __('This password reset link will expire in :count minutes.',['count'=>60]) }}</p>

<x-mails.link-button href="{{ $url }}">{{ __('Reset Password') }}</x-mails.link-button>

<br>
<p>{{ __('If you\'re having trouble clicking the ":actionText" button, copy and paste the URL below
into your web browser:',['actionText' =>  __('Reset Password') ]) }}<br></p>

<br>
<pre style="text-wrap: auto; font-size: small;">{{ $url }}</pre>
<br>

<p style="font-size: 14pt;">{{ __('If you did not request a password reset, no further action is required.') }}</p>

<x-mails.footer/>

