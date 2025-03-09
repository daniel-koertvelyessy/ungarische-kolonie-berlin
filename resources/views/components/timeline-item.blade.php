<table class="w-full text-left whitespace-nowrap">
    <colgroup>
        <col class="w-full sm:w-4/12">
        <col class="lg:w-4/12">
        <col class="lg:w-2/12">
        <col class="lg:w-1/12">
        <col class="lg:w-1/12">
    </colgroup>
    <thead class="border-b border-white/10 text-sm/6 text-white">
    <tr>
        <th scope="col" class="py-2 pr-8 pl-4 font-semibold sm:pl-6 lg:pl-8">Punkt</th>
        <th scope="col" class="hidden py-2 pr-8 pl-0 font-semibold sm:table-cell">Start</th>
        <th scope="col" class="py-2 pr-4 pl-0 text-right font-semibold sm:pr-8 sm:text-left lg:pr-20">Ende</th>
        <th scope="col" class="hidden py-2 pr-8 pl-0 font-semibold md:table-cell lg:pr-20">Ort</th>
    </tr>
    </thead>
    <tbody class="divide-y divide-white/5">
    <tr>
        <td class="py-4 pr-8 pl-4 sm:pl-6 lg:pl-8">
            @if($item->title_extern)
                {{ $item->title_extern[$locale??'de'] }}
            @endif

                {{ $item->performer }}
        </td>
        <td class="hidden py-4 pr-4 pl-0 sm:table-cell sm:pr-8">
            {{ $item->start }}
            {{ $item->end }}
        </td>
    <td>
        {{ $item->place }}
    </td>
    </tr>
    </tbody>
</table>







{{--                    "id":4,"start":"12:00","duration":null,"end":"12:15","event_id":1,"title":"Begr\u00fc\u00dfung","description":null,"notes":null,"member_id":1,"user_id":1,"created_at":"2025-03-08T16:12:33.000000Z","updated_at":"2025-03-08T16:44:49.000000Z","place":"B\u00fchne 1","performer":"","title_extern":"{\"de\":\"sdd\",\"hu\":\"saed\"}"--}}
