<?php

use App\Models\Membership\Member;

it('only board members can create a new role', function () {
    $member = Member::factory()->create();

    $this->actingAs($member->user)->assertAuthenticated();

    Livewire::test(App\Livewire\Member\Roles\Form::class)->call('save')->assertOk();

});
