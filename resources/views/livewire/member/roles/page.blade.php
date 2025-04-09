<div class="grid lg:grid-cols-2 gap-3 lg:gap-6">

    <flux:card class="space-y-6">
        @if($this->leadershipRooster->count() > 0)
            @foreach($this->leadershipRooster as $leader)
                <ul role="list"
                    class="divide-y divide-gray-200 xl:col-span-3"
                >
                    <x-leader-card :$leader
                                   :edit="true"
                    />
                </ul>
            @endforeach
        @else
            {{ __('role.leadership.empty_member_list') }}
        @endif


        <flux:separator/>

        @can('create', \App\Models\Membership\Role::class)

            <flux:modal.trigger name="add-member-to-leaderboard">
                <flux:button>{{ __('role.leadership.btn_add') }}</flux:button>
            </flux:modal.trigger>

        @endcan

        @dump($memberRoleForm)
        @dump($edit)

    </flux:card>

    <flux:card>

        <header class="flex justify-between items-center">
            <flux:heading>Rollen</flux:heading>
            <flux:modal.trigger name="make-new-role">
                <flux:button size="xs" variant="primary">{{ __('role.create.form.btn_add_new_role.label') }}</flux:button>
            </flux:modal.trigger>
        </header>

        @foreach($this->roles as $role)
            <x-role-card :$role/>
        @endforeach

    </flux:card>


    @can('create', \App\Models\Membership\MemberRole::class)
        <flux:modal name="add-member-to-leaderboard"
                    variant="flyout"
                    position="right"
        >

            <flux:heading size="lg">{{ __('role.create.form.title') }}</flux:heading>


            <form wire:submit.prevent="saveMemberRole"
                  class
            >
                <section class="space-y-6 mb-6">

                    <flux:field>
                        <flux:label></flux:label>
                        <flux:select wire:model="memberRoleForm.member_id"
                                     placeholder="{{ __('role.create.form.select_member.label') }}"
                                     variant="listbox"
                                     searchable
                        >

                            @foreach ($this->members() as $member)
                                <flux:select.option value="{{ $member->id }}">{{ $member->fullName() }}</flux:select.option>
                            @endforeach

                        </flux:select.option>
                        <flux:error name="memberRoleForm.member_id"/>
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('role.create.form.select_role.label') }}</flux:label>
                        <flux:button.group>
                            <flux:select wire:model="memberRoleForm.role_id"
                                         placeholder="{{ __('role.create.form.select_role.label') }}"
                            >
                                <flux:select.option value="null">{{ __('role.create.form.option_select_role') }}</flux:select.option>

                                @foreach ($this->roles() as $role)
                                    <flux:select.option value="{{ $role->id }}">{{ $role->name[ app()->getLocale() ] }}</flux:select.option>
                                @endforeach
                            </flux:select.option>

                            <flux:modal.trigger name="make-new-role">
                                <flux:button>{{ __('role.create.form.btn_add_new_role.label') }}</flux:button>
                            </flux:modal.trigger>
                        </flux:button.group>
                        <flux:error name="memberRoleForm.role_id"/>
                    </flux:field>


                    <flux:field>
                        <flux:label>{{ __('role.create.form.designated_at') }}</flux:label>
                        <flux:date-picker wire:model="memberRoleForm.designated_at"
                                          placeholder="{{ __('role.create.form.designated_at.placeholder') }}"
                        />
                        <flux:error name="memberRoleForm.designated_at"/>
                    </flux:field>

                    <flux:separator text="{{ __('role.create.form.designated_at') }}"
                                    class="my-4"
                    />

                    <section class="grid gap-3 grid-cols-1 sm:grid-cols-2">
                        @foreach(\App\Enums\Locale::cases() as $locale)
                            <flux:textarea label="{{ __('role.create.form.about_me') }}"
                                           badge="{{ $locale->value }}"
                                           wire:model="memberRoleForm.about_me.{{ $locale->value }}"
                            ></flux:textarea>
                        @endforeach

                    </section>


                    @if($memberRoleForm->profile_image && !$memberRoleForm->profile_image instanceof \Livewire\TemporaryUploadedFile)
                        <img src="{{ Storage::url($memberRoleForm->profile_image) }}"
                             alt="Current Profile Image"
                             class="w-32 h-32 object-cover mb-2"
                        >
                        <flux:button size="xs"
                                     variant="danger"
                                     wire:click="deleteProfileImage"
                        >
                            <flux:icon.trash variant="micro"/>
                        </flux:button>
                    @else
                        <flux:field>
                            <flux:label>{{ __('role.create.form.profile_image') }}</flux:label>
                            <div class="hidden lg:flex">
                                <flux:input type="file"
                                            accept=".jpeg,.jpg,.webp,.png"
                                            wire:model="memberRoleForm.profile_image"
                                />
                            </div>
                            <div class="lg:hidden">
                                <flux:input type="file"
                                            capture="user"
                                            accept=".jpeg,.jpg,.webp,.png"
                                            wire:model="memberRoleForm.profile_image"
                                />
                            </div>

                            <flux:error name="memberRoleForm.profile_image"/>
                        </flux:field>
                    @endif
                </section>


                <flux:button variant="primary"
                             type="submit"
                >@if(isset($memberRoleForm->id))
                        {{ __('role.create.form.btn_update_member') }}
                    @else
                        {{ __('role.create.form.btn_add_member') }}
                    @endif
                </flux:button>
            </form>

        </flux:modal>

        <flux:modal name="make-new-role"
                    class="w-1/2"
        >

            <flux:heading size="lg">Rolle zuordnen</flux:heading>


            <form wire:submit="addRole"
                  class="space-y-6"
            >

                @foreach(\App\Enums\Locale::cases() as $locale)
                    <flux:input wire:model="roleForm.name.{{ $locale->value }}"
                                label="name"
                                badge="{{ $locale->value }}"
                    />
                @endforeach

                <flux:input wire:model="roleForm.description"
                            label="description"
                />
                <flux:input type="number"
                            min="0"
                            wire:model="roleForm.sort"
                            label="sort"
                />
                <flux:button variant="primary"
                             type="submit"
                >Assign Role
                </flux:button>

            </form>

        </flux:modal>
    @endcan

</div>
