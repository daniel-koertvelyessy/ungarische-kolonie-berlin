<x-mails.header>
    <x-slot name="icon">
        <svg xmlns="http://www.w3.org/2000/svg"
             fill="none"
             viewBox="0 0 24 24"
             stroke-width="1.5"
             stroke="currentColor"
             style="width: 160px; max-width: 600px; height: auto; margin: auto; display: block;"
        >
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M21.75 9v.906a2.25 2.25 0 0 1-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 0 0 1.183 1.981l6.478 3.488m8.839 2.51-4.66-2.51m0 0-1.023-.55a2.25 2.25 0 0 0-2.134 0l-1.022.55m0 0-4.661 2.51m16.5 1.615a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V8.844a2.25 2.25 0 0 1 1.183-1.981l7.5-4.039a2.25 2.25 0 0 1 2.134 0l7.5 4.039a2.25 2.25 0 0 1 1.183 1.98V19.5Z"
            />
        </svg>
    </x-slot>
</x-mails.header>

<h1>Szia {{ $mailingList->email }},</h1>
<p style="font-size: 14pt;">{{ __('mails.mailing_list.confirmation_email_msg') }}</p>

<p>{{ __('mails.mailing_list.confirmation_email.selected_summary') }}</p>
<p>
    <br>[ {{ $mailingList->update_on_events ? 'x' : '' }} ] {{__('mails.mailing_list.confirmation_email.selected_events')}}
    <br>[ {{ $mailingList->update_on_articles ? 'x' : '' }} ] {{__('mails.mailing_list.confirmation_email.selected_posts')}}
    <br>[ {{ $mailingList->update_on_notifications ? 'x' : '' }} ] {{__('mails.mailing_list.confirmation_email.selected_notifications')}}
    <br>[ {{ $mailingList->locale }} ] {{__('mails.mailing_list.confirmation_email.locale')}}
</p>

<p>
    <a href="{{ $url?? config('app.url') }}"
       class="btn btn-primary"
    >{{ __('mails.mailing_list.confirmation_email.btn.verify_now') }}
    </a>
</p>
<br><br>

<p style="font-size: 12pt;">{{ __('mails.mailing_list.confirmation_email_msg_ignore') }}</p>

<p>{{ __('mails.mailing_list.confirmation_email_msg_changes') }}</p>

<x-mails.footer :token="$mailingList->verification_token"/>
