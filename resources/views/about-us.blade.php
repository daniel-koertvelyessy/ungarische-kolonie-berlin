<x-guest-layout :title="__('aboutus.page.title')">
    @if(Auth::user()?->is_admin)
        <div class="overflow-hidden py-24">
            <div class="mx-auto max-w-2xl px-6 lg:max-w-7xl lg:px-8">
                <div class="max-w-4xl">
                    <p class="text-base/7 font-semibold text-emerald-600">{{ __('aboutus.page.title') }}</p>
                    <h1 class="mt-2 text-4xl font-semibold tracking-tight text-pretty text-gray-900 sm:text-5xl">{{ __('welcome.mission.title') }}</h1>
                    <p class="mt-6 text-xl/8 text-balance text-gray-700">{{ __('welcome.mission.content') }}</p>
                </div>
                <section class="mt-20 grid grid-cols-1 lg:grid-cols-2 lg:gap-x-8 lg:gap-y-16">
                    <div class="lg:pr-8">
                        <h2 class="text-2xl font-semibold tracking-tight text-pretty text-gray-900">Drei Säulen der Kolónia</h2>
                        <h3 class="text-xl font-semibold tracking-tight text-pretty text-gray-900">Ungarn</h3>
                        <h3 class="text-xl font-semibold tracking-tight text-pretty text-gray-900">Gemeinschaft</h3>
                        <h3 class="text-xl font-semibold tracking-tight text-pretty text-gray-900">Kultur</h3>

                        <p class="mt-6 text-base/7 text-gray-600">Faucibus commodo massa rhoncus, volutpat. Dignissim sed eget risus enim. Mattis mauris semper sed amet vitae sed turpis id. Id dolor praesent donec est. Odio penatibus risus viverra tellus varius sit neque erat velit. Faucibus commodo massa rhoncus, volutpat. Dignissim sed eget risus enim. Mattis mauris semper sed amet vitae sed turpis id.</p>
                        <p class="mt-8 text-base/7 text-gray-600">Et vitae blandit facilisi magna lacus commodo. Vitae sapien duis odio id et. Id blandit molestie auctor fermentum dignissim. Lacus diam tincidunt ac cursus in vel. Mauris varius vulputate et ultrices hac adipiscing egestas. Iaculis convallis ac tempor et ut. Ac lorem vel integer orci.</p>
                    </div>
                    <div class="pt-16 lg:row-span-2 lg:-mr-16 xl:mr-auto">
                        <div class="-mx-8 grid grid-cols-2 gap-4 sm:-mx-16 sm:grid-cols-4 lg:mx-0 lg:grid-cols-2 lg:gap-4 xl:gap-8">
                            <div class="aspect-square overflow-hidden rounded-xl shadow-xl outline-1 -outline-offset-1 outline-black/10">
                                <img alt=""
                                     src="https://images.unsplash.com/photo-1590650516494-0c8e4a4dd67e?&auto=format&fit=crop&crop=center&w=560&h=560&q=90"
                                     class="block size-full object-cover"
                                >
                            </div>
                            <div class="-mt-8 aspect-square overflow-hidden rounded-xl shadow-xl outline-1 -outline-offset-1 outline-black/10 lg:-mt-40">
                                <img alt=""
                                     src="https://images.unsplash.com/photo-1557804506-669a67965ba0?&auto=format&fit=crop&crop=left&w=560&h=560&q=90"
                                     class="block size-full object-cover"
                                >
                            </div>
                            <div class="aspect-square overflow-hidden rounded-xl shadow-xl outline-1 -outline-offset-1 outline-black/10">
                                <img alt=""
                                     src="https://images.unsplash.com/photo-1559136555-9303baea8ebd?&auto=format&fit=crop&crop=left&w=560&h=560&q=90"
                                     class="block size-full object-cover"
                                >
                            </div>
                            <div class="-mt-8 aspect-square overflow-hidden rounded-xl shadow-xl outline-1 -outline-offset-1 outline-black/10 lg:-mt-40">
                                <img alt=""
                                     src="https://images.unsplash.com/photo-1598257006458-087169a1f08d?&auto=format&fit=crop&crop=center&w=560&h=560&q=90"
                                     class="block size-full object-cover"
                                >
                            </div>
                        </div>
                    </div>
                    <div class="max-lg:mt-16 lg:col-span-1">
                        <p class="text-base/7 font-semibold text-gray-500">Die Zahlen</p>
                        <hr class="mt-6 border-t border-gray-200">
                        <dl class="mt-6 grid grid-cols-1 gap-x-8 gap-y-4 sm:grid-cols-2">
                            <div class="flex flex-col gap-y-2 border-b border-dotted border-gray-200 pb-4">
                                <dt class="text-sm/6 text-gray-600">Gründung</dt>
                                <dd class="order-first text-6xl font-semibold tracking-tight">1846</dd>
                            </div>
                            <div class="flex flex-col gap-y-2 border-b border-dotted border-gray-200 pb-4">
                                <dt class="text-sm/6 text-gray-600">Mitglieder</dt>
                                <dd class="order-first text-6xl font-semibold tracking-tight"><span>{{ \App\Models\Membership\Member::count()  }}</span></dd>
                            </div>
                        </dl>
                    </div>
                </section>
            </div>

            <flux:separator class="my-12"/>

            <div class="mx-auto grid max-w-7xl grid-cols-1 gap-20 px-6 lg:px-8 xl:grid-cols-5">
                <div class="max-w-2xl xl:col-span-2">
                    <h2 class="text-4xl font-semibold tracking-tight text-pretty text-gray-900 sm:text-5xl">Der Vorstand</h2>
                    <p class="mt-6 text-lg/8 text-gray-600">Gewählt am 7. Februar 2025 besteht der Vorstand der Magyar Kolónia Berlin e. V. aus folgenden Mitgliedern.</p>
                </div>
                <ul role="list"
                    class="divide-y divide-gray-200 xl:col-span-3"
                >
                    <li class="flex flex-col gap-10 py-12 first:pt-0 last:pb-0 sm:flex-row">
                        <img class="aspect-4/5 w-52 flex-none rounded-2xl object-cover"
                             src="https://scontent-dus1-1.xx.fbcdn.net/v/t39.30808-1/461401783_122103993578539424_3509098661590220664_n.jpg?stp=c0.778.1374.1374a_dst-jpg_s480x480_tt6&_nc_cat=107&ccb=1-7&_nc_sid=e99d92&_nc_ohc=XfxqOMhDLOIQ7kNvgGy6XIX&_nc_oc=AdiZkRbCIt9pU-QcUOCH-oQZwkpehyVGtAWCA5RPwYrbu8LFy9Vtz-FnkEHhGECDooY&_nc_zt=24&_nc_ht=scontent-dus1-1.xx&_nc_gid=Akjs2AfMIWrpuSHDrNvdLHH&oh=00_AYB432AVcTYtghxcBoc0o5SUnJPTtZwxNYsACmWbL0VpyA&oe=67C683DF"
                             alt=""
                        >
                        <div class="max-w-xl flex-auto">
                            <h3 class="text-lg/8 font-semibold tracking-tight text-gray-900">Robotka, József</h3>
                            <p class="text-base/7 text-gray-600">Präsident</p>
                            <p class="mt-6 text-base/7 text-gray-600">Ultricies massa malesuada viverra cras lobortis. Tempor orci hac ligula dapibus mauris sit ut eu. Eget turpis urna maecenas cras. Nisl dictum.</p>

                            <a href="mailto:jozsef@magyar-kolonia-berlin.org"
                               class="text-gray-400 hover:text-gray-500 mt-6 flex gap-x-6"
                            >
                                <flux:icon.envelope-open/>
                                jozsef@magyar-kolonia-berlin.org
                            </a>

                        </div>
                    </li>

                    <!-- More people... -->
                </ul>
            </div>
        </div>

    @else
      <article class="flex space-x-4">
          <div class="pt-3 sm:pt-5">
              <h1 class="text-5xl">{{ __('welcome.mission.title') }}</h1>

              <p class="mt-4 text-sm/relaxed">
                  {{ __('welcome.mission.content') }}
              </p>
          </div>

          <x-madar-virag-minta-bg class="w-60" />
      </article>
    @endif
</x-guest-layout>
