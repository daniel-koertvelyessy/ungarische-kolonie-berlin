{{--<x-mails.header/>--}}


@if($recipient['type'] === 'member')
    @php
    $member = \App\Models\Membership\Member::find($recipient['id']);
    @endphp
    <h1>Szia, {{ $member->fullName() }}</h1>
@else

    <h1>Szia!</h1>

@endif

<h2>{{ $header }}</h2>

<p>{{ $content }}</p>

<a href="{{ route($notificationType.'.show',$notifiable->slug[$recipient['locale']]) }}"  class="btn btn-primary"> {{  }}</a>

@if(isset($recipient['verification_token']))
    <x-mails.footer :token="$recipient['verification_token']"/>
@else
    <x-mails.footer/>
@endif
