<?php

declare(strict_types=1);

namespace App\Actions\Member;

use App\Livewire\Forms\Member\MemberRoleForm;
use App\Models\Membership\MemberRole;
use Illuminate\Notifications\Action;
use Illuminate\Support\Facades\DB;

final class CreateMemberRole extends Action
{
    public static function handle(MemberRoleForm $form): MemberRole
    {
        return DB::transaction(function () use ($form) {

            return MemberRole::create([
                'member_id' => $form->member_id,
                'role_id' => $form->role_id,
                'designated_at' => $form->designated_at,
                'resigned_at' => $form->resigned_at,
                'about_me' => $form->about_me,
                'profile_image' => $form->profile_image,

            ]);

        });

    }
}
