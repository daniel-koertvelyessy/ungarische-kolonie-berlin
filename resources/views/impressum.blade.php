<x-guest-layout :title="__('impressum.title')">
    <h1 class="text-5xl">{{ __('impressum.title') }}</h1>

    <dl class="divide-y divide-zinc-50 dark:divide-zinc-600">
        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
            <dt class="text-sm/6 font-medium ">{{__('impressum.register_name')}}</dt>
            <dd class="mt-1 text-sm/6 sm:col-span-2 sm:mt-0">Magyar-Kolónia Berlin (Ungarische-Kolonie-Berlin) e.V.</dd>
        </div>
        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
            <dt class="text-sm/6 font-medium ">{{__('impressum.register_id')}}</dt>
            <dd class="mt-1 text-sm/6 sm:col-span-2 sm:mt-0">95 VR 1881 Nz</dd>
        </div>
        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
            <dt class="text-sm/6 font-medium ">{{__('impressum.register_at')}}</dt>
            <dd class="mt-1 text-sm/6 sm:col-span-2 sm:mt-0">1953.10.28</dd>
        </div>
        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
            <dt class="text-sm/6 font-medium ">{{__('impressum.register_place')}}</dt>
            <dd class="mt-1 text-sm/6 sm:col-span-2 sm:mt-0">Berlin</dd>
        </div>

        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
            <dt class="text-sm/6 font-medium ">{{__('impressum.represented_by')}}</dt>
            <dd class="mt-1 text-sm/6 sm:col-span-2 sm:mt-0">
                <p>{{ __('impressum.president') }}: József Robotka</p>

                <p>{{ __('impressum.sub_president') }}: Mátyás Temesi</p>

            </dd>
        </div>
        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
            <dt class="text-sm/6 font-medium ">  V.i.S.d § 18 Abs. 2 MStV</dt>
            <dd class="mt-1 text-sm/6 sm:col-span-2 sm:mt-0">
                <ul>
                    <li>Józef Robotka</li>
                    <li>0163 377 20 91</li>
                    <li>jozef@ungarische-kolonie-berlin.org</li>
                </ul>
            </dd>
        </div>

    </dl>
</x-guest-layout>
