<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      class="scroll-smooth"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1"
    >

    <title>{{ __('members.apply.print.title') }}</title>

    <!-- Fonts -->
    <link rel="preconnect"
          href="https://fonts.bunny.net"
    >
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap"
          rel="stylesheet"
    />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="icon"
          href="{{ Vite::asset('resources/images/favicons/favicon.ico') }}"
          sizes="48x48"
    >
    <link rel="icon"
          href="{{ Vite::asset('resources/images/kolonia_icon.svg') }}"
          sizes="any"
          type="image/svg+xml"
    >
    <link rel="apple-touch-icon"
          href="{{ Vite::asset('resources/images/favicons/apple-icon-180x180.png') }}"
    >


</head>
<body class="font-sans antialiased">
<div class="bg-white text-black text-sm pt-32">

    <p class="text-xs">Atn:</p>
    <p>Magayar Kolónia Berlin E. V.</p>
    <p>Bulgarstraße 12</p>
    <p>13458 Berlin</p>


    <h1 class="text-xl text-emerald-600 mb-12 mt-32">{{ __('members.apply.print.title') }}</h1>
    <p class="my-3">{{ __('members.apply.print.greeting') }}</p>
    <p>{{ __('members.apply.print.text') }}</p>


    <p class="mt-14">{{ __('members.apply.print.overview.person') }}</p>
    <dl class="divide-y divide-gray-100">
        <div class="grid grid-cols-3 gap-4 px-0">
            <dt class="text-sm/6 py-1 font-medium text-gray-900">{{ __('members.name') }}, {{ __('members.first_name') }}</dt>
            <dd class="text-sm/6 py-1 text-gray-700 col-span-2">{{ $member->name }}, {{ $member->first_name }}</dd>
        </div>
        <div class="grid grid-cols-3 gap-4 px-0">
            <dt class="text-sm/6 py-1 font-medium text-gray-900">{{ __('members.birth_date') }}</dt>
            <dd class="text-sm/6 py-1 text-gray-700 col-span-2">{{ $member->birth_date??'-' }} </dd>
        </div>
        <div class="grid grid-cols-3 gap-4 px-0">
            <dt class="text-sm/6 py-1 font-medium text-gray-900">{{ __('members.gender') }}</dt>
            <dd class="text-sm/6 py-1 text-gray-700 col-span-2">{{ \App\Enums\Gender::value($member->gender )  }} </dd>
        </div>
        <div class="grid grid-cols-3 gap-4 px-0">
            <dt class="text-sm/6 py-1 font-medium text-gray-900">{{ __('members.locale') }}</dt>
            <dd class="text-sm/6 py-1 text-gray-700 col-span-2">{{ \App\Enums\Locale::value($member->locale )  }} </dd>
        </div>
    </dl>

    <p class="mt-14">{{ __('members.apply.print.overview.contact') }}</p>
    <dl class="divide-y divide-gray-100">
        <div class="grid grid-cols-3 gap-4 px-0">
            <dt class="text-sm/6 py-1 font-medium text-gray-900">{{ __('members.address') }} </dt>
            <dd class="text-sm/6 py-1 text-gray-700 col-span-2">{{ $member->address??'-' }}</dd>
        </div>
        <div class="grid grid-cols-3 gap-4 px-0">
            <dt class="text-sm/6 py-1 font-medium text-gray-900">{{ __('members.city') }}</dt>
            <dd class="text-sm/6 py-1 text-gray-700 col-span-2">{{ $member->city??'-' }} </dd>
        </div>
        @if($member->country !== 'Deutschland')
            <div class="grid grid-cols-3 gap-4 px-0">
                <dt class="text-sm/6 py-1 font-medium text-gray-900">{{ __('members.country') }}</dt>
                <dd class="text-sm/6 py-1 text-gray-700 col-span-2">{{ $member->country??'-'}} </dd>
            </div>
        @endif
        <div class="grid grid-cols-3 gap-4 px-0">
            <dt class="text-sm/6 py-1 font-medium text-gray-900">{{ __('members.phone') }}</dt>
            <dd class="text-sm/6 py-1 text-gray-700 col-span-2">{{ $member->phone??'-'  }} </dd>
        </div>
        <div class="grid grid-cols-3 gap-4 px-0">
            <dt class="text-sm/6 py-1 font-medium text-gray-900">{{ __('members.mobile') }}</dt>
            <dd class="text-sm/6 py-1 text-gray-700 col-span-2">{{ $member->mobile??'-'  }} </dd>
        </div>
        <div class="grid grid-cols-3 gap-4 px-0">
            <dt class="text-sm/6 py-1 font-medium text-gray-900">{{ __('members.email') }}</dt>
            <dd class="text-sm/6 py-1 text-gray-700 col-span-2">{{ $member->email??'-'  }} </dd>
        </div>
    </dl>
    @if($member->is_deducted)
        <p class="mt-14">{{ __('members.apply.discount.label') }}</p>
        <dl class="divide-y divide-gray-100">
            <div class="grid grid-cols-3 gap-4 px-0">
                <dt class="text-sm/6 py-1 font-medium text-gray-900">{{ __('members.apply.discount.reason.label') }} </dt>
                <dd class="text-sm/6 py-1 text-gray-700 col-span-2">{{ $member->deduction_reason??'-' }}</dd>
            </div>
        </dl>
    @endif

    <p class="mt-14">{{ __('members.apply.print.regards') }}</p>
    <p class="mt-3">{{ $member->name }}, {{ $member->first_name }}</p>
    <p class="mt-48 pt-3 border-t border-gray-900 w-64">{{ $member->city }} {{ date('Y-m-d') }}</p>

</div>
</body>
</html>
