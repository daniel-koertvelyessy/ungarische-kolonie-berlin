<?php

namespace App\Actions\Member;

use App\Livewire\Forms\Member\RoleForm;
use App\Models\Membership\Role;
use Illuminate\Notifications\Action;
use Illuminate\Support\Facades\DB;

final class UpdateRole extends Action
{
    public static function handle(RoleForm $form, Role $role): Role
    {
        return DB::transaction(function () use ($form, $role) {
            return Role::query()
                ->where('id', $role->id)
                ->update([
                    'id' => $form->id,
                    'name' => $form->name,
                    'description' => $form->description,
                    'sort' => $form->sort,
                ]) ?
                $role
                : Role::query()
                    ->create([
                        'name' => $form->name,
                        'description' => $form->description,
                        'sort' => $form->sort,
                    ]);
        });
    }
}
