<?php

test('user creation records history', function () {
    config(['queue.default' => 'sync']);
    $user = \App\Models\User::factory()->create();
    expect(\App\Models\History::where('action', 'created')->count())->toBe(1); // Should be 1
});

test('member creation records history', function () {
    config(['queue.default' => 'sync']);
    $member = \App\Models\Membership\Member::factory()->create();
    expect(\App\Models\History::where('action', 'created')->count())->toBe(2); // Just Member
});

test('event creation records history', function () {
    config(['queue.default' => 'sync']);
    $event = \App\Models\Event\Event::factory()->create();
    expect(\App\Models\History::where('action', 'created')
        ->where('historable_type', \App\Models\Event\Event::class)
        ->count())->toBe(1); // Just Event
});
