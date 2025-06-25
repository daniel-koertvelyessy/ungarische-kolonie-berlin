<?php

use App\Models\Membership\Member;
use App\Models\User;

it('only board members can create a new role', function () {
    $member = Member::factory()->withUser()->create(['user_id' => User::factory()->create(['email_verified_at' => now()])->id]);

    $this->actingAs($member->user)->assertAuthenticated();

    Livewire::test(App\Livewire\Member\Roles\Form::class)->call('save')->assertOk();

});
