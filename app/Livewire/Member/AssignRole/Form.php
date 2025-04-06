<?php

namespace App\Livewire\Member\AssignRole;

use App\Models\Membership\Member;
use App\Models\Membership\MemberRole;
use App\Models\Membership\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    public $memberId;

    public $roleId;

    public $designatedAt;

    public array $aboutMe = [];

    public $sort;

    public $profileImage;

    public $role_name;
    public $role_description;
    public $role_sort;

    public function mount(): void
    {
        $this->designatedAt = Carbon::today()->toDateString(); // Default to today
        $this->role_sort = 0; // Default sort
    }

    public function save(): void
    {
        $this->validate();

        /** @var Role|null $currentRole */
        $currentRole = Member::find($this->memberId)
            ->roles()
            ->wherePivot('resigned_at', null)
            ->first();

        if ($currentRole) {
            // Explicitly type the pivot as MemberRole
            /** @var MemberRole $pivot */
            $pivot = $currentRole->pivot;

            \DB::table('member_role')
                ->where('member_id', $this->memberId)
                ->where('role_id', $currentRole->id) // Use $currentRole->id, not pivot->id
                ->whereNull('resigned_at')
                ->update(['resigned_at' => Carbon::now()]);
        }

        // Handle the new profile image (or reuse the old one if none uploaded)
        $newImagePath = $this->profileImage
            ? $this->profileImage->store('profile_images', 'public')
            : ($currentRole ? $currentRole->pivot->profile_image : null);

        // Create the new role assignment
        DB::table('member_role')->insert([
            'member_id' => $this->memberId,
            'role_id' => $this->roleId,
            'designated_at' => $this->designatedAt,
            'about_me' => $this->aboutMe ?? ($currentRole ? $currentRole->pivot->about_me : null),
            'sort' => $this->sort,
            'profile_image' => $newImagePath,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        session()->flash('message', 'Role assigned successfully!');
        $this->reset(); // Clear form
    }

    protected function rules(): array
    {
        return [
            'memberId' => 'required|exists:members,id',
            'roleId' => 'required|exists:roles,id',
            'designatedAt' => 'required|date',
            'aboutMe' => 'nullable|string|max:500',
            'sort' => 'required|integer|min:0',
            'profileImage' => 'nullable|image|max:2048', // Max 2MB
        ];
    }

    public function addRole()
    {

    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.member.assign-role.form', [
            'members' => Member::all(),
            'roles' => Role::all(),
        ]);
    }
}
