<?php

namespace App\Livewire\Forms\Member;

use App\Actions\Member\CreateMemberRole;
use App\Actions\Member\UpdateMemberRole;
use App\Models\Membership\MemberRole;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Form;

class MemberRoleForm extends Form
{
    protected MemberRole $memberRole;

    public int $id;

    public $member_id;

    public $role_id;

    public $designated_at;

    public $resigned_at;

    public $about_me;

    public $profile_image;

    public function set(int $memberRoleId): void
    {
        try {
            $this->memberRole = MemberRole::query()
                ->findOrFail($memberRoleId);
            $this->id = $this->memberRole->id;
            $this->member_id = $this->memberRole->member_id;
            $this->role_id = $this->memberRole->role_id;
            $this->designated_at = $this->memberRole->designated_at;
            $this->resigned_at = $this->memberRole->resigned_at;
            $this->about_me = $this->memberRole->about_me;
            $this->profile_image = $this->memberRole->profile_image;
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException;
        }
    }

    public function init(): void
    {
        $this->about_me = ['de' => '', 'hu' => ''];
        $this->designated_at = Carbon::today()
            ->toDateString();
    }

    protected function uploadFile(): void
    {
        if (isset($this->profile_image) &&   $this->profile_image === anInstanceOf(TemporaryUploadedFile::class))  {
            $file = $this->profile_image->store('profile_images', 'public');
            $this->profile_image = $file;
        }
    }

    public function create(): MemberRole
    {
        $this->validate();

        $this->uploadFile();

        return CreateMemberRole::handle($this);
    }

    public function update(): MemberRole
    {
        $this->validate();

        $this->uploadFile();

        return UpdateMemberRole::handle($this, $this->id);
    }

    protected function rules(): array
    {
        $profile_image_rule = ['nullable'];

        if ($this->profile_image instanceof \Livewire\TemporaryUploadedFile) {
            $profile_image_rule = array_merge($profile_image_rule, ['image', 'mimes:jpg, jpeg, gif, png', 'max:20000']);
        }

        return [
            'member_id'     => ['required', 'integer', 'exists:App\Models\Membership\Member,id'],
            'role_id'       => ['required', 'integer', 'exists:App\Models\Membership\Role,id'],
            'designated_at' => ['required', 'date'],
            'resigned_at'   => ['nullable', 'date'],
            'about_me.*'    => ['nullable', 'string'],
            'profile_image' => $profile_image_rule,
        ];
    }

    protected function messages(): array
    {
        return [
            'designated_at.required' => __('role.validation.error_required.designated_at'),
            'member_id.required'     => __('role.validation.error_required.member_id'),
            'role_id.required'       => __('role.validation.error_required.role_id'),
        ];
    }
}
