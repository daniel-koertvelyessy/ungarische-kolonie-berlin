<?php

use App\Enums\MemberFamilyStatus;
use App\Enums\MemberType;

test('any visitor can apply as member', function () {

    Livewire::test(\App\Livewire\Member\Apply\Page::class)->assertOk();

    Livewire::test(\App\Livewire\Member\Create\Form::class, [
        'locale' => 'de',
        'gender' => \App\Enums\Gender::ma->value,
        'applied_at' => \Carbon\Carbon::now()->format('Y-m-d'),
        'family_status' => MemberFamilyStatus::NN->value,
        'type' => MemberType::AP->value,
        'country' => 'de',
    ])->assertOk();

});
