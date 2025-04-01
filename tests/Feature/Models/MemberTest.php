<?php

use App\Models\Membership\Member;
use App\Models\User;
use Carbon\Carbon;

test('a member can be created', function () {
    $member = Member::factory()->create();

    expect($member)->toBeInstanceOf(Member::class);
});

test('a member has a full name', function () {
    $member = Member::factory()->create([
        'name' => 'Doe',
        'first_name' => 'John',
    ]);

    expect($member->fullName())->toBe('Doe, John');
});

test('a member can have a user', function () {
    $user = User::factory()->create();
    $member = Member::factory()->create(['user_id' => $user->id]);

    expect($member->user)->toBeInstanceOf(User::class);
});

test('a member can have multiple transactions', function () {
    $member = Member::factory()->create();

    // Create transactions via MemberTransaction
    \App\Models\Membership\MemberTransaction::factory()->count(3)->create([
        'member_id' => $member->id,
        'transaction_id' => \App\Models\Accounting\Transaction::factory()->create()->id,
    ]);

    expect($member->transactions)->toHaveCount(3);
});

test('a member can detect a birthday', function () {
    $member = Member::factory()->create(['birth_date' => Carbon::today('Europe/Berlin')]);

    expect($member->hasBirthdayToday())->toBeTrue();
});

test('a member fee is calculated correctly', function () {
    $feeString = Member::feeForHumans(1500);

    expect($feeString)->toBe('15,00');
});

test('a member invitation status is checked correctly', function () {
    $member = Member::factory()->create(['email' => 'test@example.com']);

    expect($member->checkInvitationStatus())->toBe('none');
});
