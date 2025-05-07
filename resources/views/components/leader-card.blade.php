@if($leader)
    @php
    $profile_link = $leader->profile_image ?  '/'.$leader->profile_image : 'https://ui-avatars.com/api/?name='.urlencode($leader->member->first_name.' '.$leader->member->name).'&color=7F9CF5&background=EBF4FF';
    @endphp
    <li class="flex flex-col gap-10 py-12 first:pt-0 last:pb-0 " wire:key="{{ $leader->id }}">
        <img class="aspect-4/5 w-52 flex-none rounded-2xl object-cover" src="{{ $profile_link }}" alt="Profile image {{ $leader->member->fullName() }}">
        <div class="max-w-xl flex-auto">
            <h3 class="text-lg/8 font-semibold tracking-tight text-gray-900 dark:text-zinc-300">{{ $leader->member->fullName() }}</h3>
            <p class="text-base/7 text-gray-600 dark:text-zinc-300">{{ $leader->role->name[app()->getLocale()] }}</p>

            <p class="mt-6 text-base/7 text-gray-600 dark:text-zinc-400">{{ $leader->about_me[app()->getLocale()]??'-' }}</p>

            <ul role="list" class="mt-6 flex gap-x-6">
                <li>
                    <a href="mailto:{{ $leader->member->email }}" class="text-gray-400 hover:text-gray-500 underline">
                        {{ $leader->member->email }}
                    </a>
                </li>
            </ul>


        </div>
        @if(isset($edit))
       <div class="flex flex-col gap-2">
           <flux:button size="xs" wire:click="editMemberRole({{ $leader->id }})">
               <flux:icon.pencil-square class="size-4" />
           </flux:button>
           <flux:button size="xs" wire:click="removeMemberRole({{ $leader->id }})">
               <flux:icon.trash class="size-4 text-red-600" />
           </flux:button>
       </div>
        @endif
    </li>
@endif
