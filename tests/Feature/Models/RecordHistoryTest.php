<?php

use App\Models\Membership\Member;
use App\Models\User;

test('user creation records history', function () {
    config(['queue.default' => 'sync']);
    $user = Member::factory()->withUser()->create(['user_id' => User::factory()->create(['email_verified_at' => now()])->id])->user;
    expect(\App\Models\History::where('action', 'created')->count())->toBe(3); // TODO check why this is 3 and not 1
});

test('member creation records history', function () {
    config(['queue.default' => 'sync']);
    $member = Member::factory()->withUser()->create(['user_id' => User::factory()->create(['email_verified_at' => now()])->id]);
    expect(\App\Models\History::where('action', 'created')->count())->toBe(3); // TODO check why this is 3 and not 1
});

test('event creation records history', function () {
    config(['queue.default' => 'sync']);
    $event = \App\Models\Event\Event::factory()->create();
    expect(\App\Models\History::where('action', 'created')
        ->where('historable_type', \App\Models\Event\Event::class)
        ->count())->toBe(1); // Just Event
});
