@php use App\Models\Blog\Post; @endphp
@php use App\Enums\EventStatus; @endphp
@php use App\Models\Blog\PostType; @endphp
<div class="space-y-6">

    <flux:heading size="lg">{{__('post.backend.index.page.title')}}</flux:heading>

    <nav class="flex gap-3 items-center">
        @can('create',Post::class)
            <flux:button href="{{ route('backend.posts.create') }}"
                         variant="primary"
                         icon-trailing="plus"
                         size="sm"
            ><span class="hidden lg:inline">{{ __('post.backend.index.btn.start_new') }}</span>
            </flux:button>
            <flux:separator vertical/>
        @endcan


        <flux:input size="sm"
                    wire:model.live.debounce="search"
                    clearable
                    icon="magnifying-glass"
                    placeholder="Suche ..."
        />
        <flux:separator vertical/>
        <flux:select variant="listbox"
                     multiple
                     placeholder="Filter Status.."
                     size="sm"
                     wire:model.live="filteredByStatus"
                     selected-suffix="{{ __('gewählt') }}"
        >
            @foreach(EventStatus::cases() as $status)
                <flux:select.option value="{{ $status->value }}">{{ EventStatus::value($status->value) }}</flux:select.option>
            @endforeach
        </flux:select>
        <flux:select variant="listbox"
                     multiple
                     placeholder="Filter Typ.."
                     size="sm"
                     wire:model.live="filteredByType"
                     selected-suffix="{{ __('gewählt') }}"
        >
            @foreach(PostType::all() as $type)
                <flux:select.option value="{{ $type->id }}">{{ $type->name[$locale] }}</flux:select.option>
            @endforeach
        </flux:select>

    </nav>

    <flux:table :paginate="$this->posts">
        <flux:table.columns>
            <flux:table.column sortable
                               :sorted="$sortBy === 'label'"
                               :direction="$sortDirection"
                               wire:click="sort('label')"
            >Name (intern)
            </flux:table.column>
            <flux:table.column sortable
                               :sorted="$sortBy === 'date'"
                               :direction="$sortDirection"
                               wire:click="sort('published_at')"
            >Veröffentlicht am
            </flux:table.column>
            <flux:table.column sortable
                               :sorted="$sortBy === 'status'"
                               :direction="$sortDirection"
                               wire:click="sort('status')"
            >Status
            </flux:table.column>
            <flux:table.column sortable
                               :sorted="$sortBy === 'type'"
                               :direction="$sortDirection"
                               wire:click="sort('type')"
            >Typ
            </flux:table.column>
            <flux:table.column sortable
                               :sorted="$sortBy === 'title'"
                               :direction="$sortDirection"
                               wire:click="sort('title')"
            >Titel
            </flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($this->posts as $post)

                <flux:table.row :key="$post->id">
                    <flux:table.cell class="text-wrap hyphens-auto">
                        {{ $post->label }}
                    </flux:table.cell>

                    <flux:table.cell>{{ $post->published_at??'-' }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:badge size="sm"
                                    :color="$post->status_color()"
                                    inset="top bottom"
                        >{{ $post->status }}</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell>

                        <flux:badge size="sm"
                                    :color="$post->typeColor()"
                                    inset="top bottom"
                        >{{ $post->type->name[$locale] }}</flux:badge>
                    </flux:table.cell>

                    <flux:table.cell variant="strong">{{ $post->title[$locale] }}</flux:table.cell>
                    @can('update',$post)
                        <flux:table.cell>
                            <flux:dropdown>
                                <flux:button variant="ghost"
                                             size="sm"
                                             icon="ellipsis-horizontal"
                                             inset="top bottom"
                                ></flux:button>
                                <flux:menu>
                                    <flux:menu.item wire:navigate
                                                    href="{{ route('backend.posts.show',$post) }}"
                                                    icon="pencil-square"
                                    >bearbeiten
                                    </flux:menu.item>
                                    @can('delete',$post)
                                        <flux:menu.item variant="danger"
                                                        wire:click="confirmDeletion({{ $post->id }})"
                                                        icon="trash"
                                        >löschen
                                        </flux:menu.item>
                                    @endcan
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    @endcan
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>


</div>
