<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Poster: {{$event->title[$locale??'de']}}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
    <style>
        @page {
            size: A4 portrait;
            margin: 0;
        }
        body {
            width: 210mm;
            height: 297mm;
            margin: 0;
            padding: 0;
        }

        </style>
        </head>
<body class="font-sans  bg-white relative">

<div class="absolute border-4 border-red-700 inset-2"></div>
<div class="absolute border-4 border-green-700 inset-4"></div>
<div class=" flex flex-col overflow-hidden items-center justify-between  py-10">

    <article class="px-8">
        <header class="flex flex-col justify-center items-center  ">
            <h1 class="text-green-700 text-6xl mb-10">{{ $event->title[$locale??'de'] }}</h1>
        </header>

        <section class="my-3 ">
            {!! $event->excerpt[$locale??'de'] !!}
        </section>


        <section>
            @if($event->timelines()->count()>0)

                <h2 class="text-xl mt-9 mb-4">{{ __('event.timeline.heading',[],$locale??'de') }}</h2>

                <table>
                @foreach($event->timelines()->orderBy('start','desc')->get() as $item)
                   <tr class="">
                       <td class="text-base font-medium text-gray-900 p-3">{{ $item->title_extern[$locale??'de'] }}</td>
                       <td class="text-sm text-gray-700 p-3">
                           @if($item->performer)
                               <p><span>{{ __('event.timeline.performer',[],$locale??'de') }}</span> <strong>{{ $item->performer }}</strong></p>
                           @endif
                               <p><span>{{ __('event.timeline.start',[],$locale??'de') }}</span> <strong>{{ $item->start->format('H:i') }}</strong> <span>{{ __('event.timeline.end',[],$locale??'de') }}</span> <strong>{{ $item->end->format('H:i') }}</strong></p>
                       </td>
                       <td class="text-sm">
                           @if($item->place)
                               <p><span>{{ __('event.timeline.place',[],$locale??'de') }}:</span> <strong>{{ $item->place }}</strong></p>
                           @endif
                       </td>
                   </tr>
                @endforeach
                </table>

            @endif
        </section>

        <aside class="absolute flex bottom-40 left-5 right-5 gap-12 divide-x-2 divide-green-700 bg-green-50 py-4">
            <div class="flex flex-col pl-6">
                <span class="text-5xl text-green-700">{{ \Carbon\Carbon::createFromDate($event->event_date)->locale($locale??'de')->isoFormat('MMMM')  }}</span>
                <span class="text-9xl  px-8 py-3 text-red-700">{{  \Carbon\Carbon::createFromDate($event->event_date)->locale($locale??'de')->isoFormat('Do') }}</span>
            </div>
            <div class="flex flex-col mt-3 w-full pr-6">
                <div class="text-5xl text-red-700 pb-4 border-b-2 border-green-700">{{ $event->start_time->format('H:s') }} - {{ $event->end_time->format('H:s') }}</div>
                <div class=" mt-3 text-green-700">
                    <p class="text-4xl">{{ $event->venue->name }}</p>
                    <p class="text-xl">{{ $event->venue->address(false) }}</p>
                </div>
            </div>
        </aside>

    </article>


    <footer class="absolute bottom-12 left-8 right-8">
        <section class="flex justify-between w-full gap-3 items-start">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 400 400"
                     fill-rule="evenodd"
                     stroke-linejoin="round"
                     stroke-miterlimit="2"
                     class="h-20"
                >
                    <path d="M88.054 3.191c-21.497 23.68-35.297 49.696-42.81 73.311-6.834 21.481-9.726 39.136 0 67.63 7.832 22.949 32.643 54.736 57.969 77.292 20.73 17.13 41.953 42.002 51.528 64.41 13.349 31.242-.106 58.062-15.172 69.92-23.735 18.682-49.621 18.898-67.537 7.298-31.084-20.122-35.516-36.975-39.67-64.336-5.217-34.353-4.393-68.703 0-103.056-14.731 32.298-19.861 81.585-16.103 112.718 6.18 55.618 39.332 75.907 56.613 83.443 44.024 19.194 141.354-16.193 104.228-120.096-10.022-28.047-49.431-57.367-65.228-75.691C44.007 136.964 45.875 79.736 88.054 3.191zm223.888 0c21.497 23.68 35.297 49.696 42.81 73.311 6.834 21.481 9.726 39.136 0 67.63-7.832 22.949-32.643 54.736-57.969 77.292-20.73 17.13-41.953 42.002-51.528 64.41-13.349 31.242.106 58.062 15.172 69.92 23.735 18.682 49.621 18.898 67.537 7.298 31.084-20.122 35.516-36.975 39.67-64.336 5.217-34.353 4.393-68.703 0-103.056 14.731 32.298 19.861 81.585 16.103 112.718-6.18 55.618-39.332 75.907-56.613 83.443-44.024 19.194-141.354-16.193-104.228-120.096 10.022-28.047 49.431-57.367 65.228-75.691 67.866-59.07 65.998-116.299 23.819-192.844z"
                          fill="#d22929"
                    />
                    <path d="M205.305 229.695s5.803-22.035 9.323-26.228c10.296-21.642 60.903-51.277 72.107-68.957 5.298-8.36 15.388-24.427 13.236-45.126-1.066-10.27-5.646-21.716-16.102-32.205-8.592-8.618-23.159-17.642-41.867-16.102-13.017 1.072-30.195 13.088-35.425 28.985 0 0-8.051-27.912-48.308-25.764-14.383.766-32.257 8.596-41.866 19.323-23.081 25.764-8.064 60.307 5.778 78.133 19.59 25.226 55.28 54.633 55.28 54.633 4.712 3.63 24.086 23.2 27.844 33.31zm-1.739-137.593s7.768-18.66 28.543-22.154c3.948-.667 22.308-2.383 28.109 13.642 4.019 11.098 1.681 31.819-9.787 48.031-32.614 37.033-48.182 68.378-48.182 68.378-6.489-20.65-24.138-31.98-53.641-75.189-14.083-20.624-11.89-36.021-2.857-45.606 7.478-7.935 21.896-13.993 33.925-8.199 24.975 12.038 23.89 21.097 23.89 21.097zM66.158 234.075s1.523 20.044 6.216 27.239c8.051 12.344 36.456 31.706 43.103 47.064 5.984 13.829-3.221 45.087-3.221 45.087s-1.752-16.293-6.441-22.543c-8.051-10.734-35.715-27.368-41.867-41.866-7.916-24.286-3.845-40.079 2.209-54.98zm267.562 0s-1.523 20.044-6.216 27.239c-8.051 12.344-36.456 31.706-43.103 47.064-5.984 13.829 3.221 45.087 3.221 45.087s1.752-16.293 6.441-22.543c8.051-10.734 35.715-27.368 41.867-41.866 7.916-24.286 3.845-40.079-2.209-54.98z"
                          fill="#359040"
                    />
                </svg>
            </div>
            <aside class="max-h-36">
                <p>Magyar Kolónia Berlin e. V. | 95 VR 1881 Nz</p>
                <p class="text-sm">{!!   \App\Models\Membership\Member::leaderBoardHtml($locale??'de') !!}</p>
            </aside>
            <figure>
                {!! $qrcode !!}
            </figure>
        </section>
    </footer>


</div>


</body>
</html>
