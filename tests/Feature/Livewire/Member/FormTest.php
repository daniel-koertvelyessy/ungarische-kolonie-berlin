<?php

use App\Livewire\Member\Create\Form;
use App\Models\Membership\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Livewire\Livewire;
use Tests\Traits\ValidatesTranslations;

// uses(RefreshDatabase::class);

test('defaults are set on mount', function () {
    $user = User::factory()
        ->create(['is_admin' => true]);
    $this->actingAs($user);

    $component = Livewire::test(Form::class);

    expect($component->form->locale)->toBe(app()->getLocale());
    expect($component->form->gender)->toBe(\App\Enums\Gender::ma->value);
    expect($component->form->family_status)->toBe(\App\Enums\MemberFamilyStatus::NN->value);
    expect($component->form->type)->toBe(\App\Enums\MemberType::AP->value);
    expect($component->form->country)->toBe('Deutschland');
    expect($component->form->applied_at)->toBeInstanceOf(\Carbon\Carbon::class);
});

test('checkEmail sets nomail correctly', function () {
    $user = User::factory()
        ->create(['is_admin' => true]);
    $this->actingAs($user);

    $component = Livewire::test(Form::class)
        ->set('form.email', '') // Empty email
        ->call('checkEmail');

    expect($component->nomail)->toBeTrue();

    $component->set('form.email', 'test@example.com')
        ->call('checkEmail');

    expect($component->nomail)->toBeFalse();
});

test('checkBirthDate sets deduction based on age', function () {
    $user = User::factory()
        ->create(['is_admin' => true]);
    $this->actingAs($user);

    $ageDiscounted = Member::$age_discounted; // e.g., 65

    // Older than threshold
    $oldDate = now()
        ->subYears($ageDiscounted + 1)
        ->toDateString();
    $component = Livewire::test(Form::class)
        ->set('form.birth_date', $oldDate)
        ->call('checkBirthDate');

    expect($component->form->is_deducted)->toBeTrue();
    expect($component->form->deduction_reason)->toBe("Älter als $ageDiscounted");

    // Younger than threshold
    $youngDate = now()
        ->subYears($ageDiscounted - 1)
        ->toDateString();
    $component->set('form.birth_date', $youngDate)
        ->call('checkBirthDate');

    expect($component->form->is_deducted)->toBeFalse();
    expect($component->form->deduction_reason)->toBe('');
});

test('checkBirthDate applies deduction for older members', function () {
    $user = User::factory()
        ->create(['is_admin' => true]);
    $this->actingAs($user);

    $ageDiscounted = Member::$age_discounted;

    $component = Livewire::test(Form::class)
        ->set('form.birth_date', now()
            ->subYears($ageDiscounted + 1)
            ->toDateString())
        ->call('checkBirthDate');

    expect($component->form->is_deducted)->toBeTrue();
    expect($component->form->deduction_reason)->toBe("Älter als $ageDiscounted");

    $component->set('form.birth_date', now()
        ->subYears($ageDiscounted - 1)
        ->toDateString())
        ->call('checkBirthDate');

    expect($component->form->is_deducted)->toBeFalse();
    expect($component->form->deduction_reason)->toBe('');
});

test('store creates member with application and sends notifications', function () {
    $user = User::factory()
        ->create(['is_admin' => true]);
    $this->actingAs($user);

    Notification::fake();

    $boardMember = Member::factory()
        ->create([
            'type' => \App\Enums\MemberType::MD->value,
            'name' => 'Board Guy',
            'email' => 'board@example.com',
        ]);

    $component = Livewire::test(Form::class)
        ->set('application', true)
        ->set('form.name', 'John Doe')
        ->set('form.email', 'john@example.com')
        ->set('form.gender', \App\Enums\Gender::ma->value)
        ->set('form.birth_date', now()
            ->subYears(30)
            ->toDateString())
        ->set('form.family_status', \App\Enums\MemberFamilyStatus::NN->value)
        ->set('form.type', \App\Enums\MemberType::AP->value)
        ->set('form.country', 'Deutschland')
        ->call('store');

    $member = Member::where('email', 'john@example.com')
        ->first();
    expect($member)->not->toBeNull();
    expect($member->name)->toBe('John Doe');
    expect($member->email)->toBe('john@example.com');

    // Re-fetch to match Livewire’s hydrated instance
    $boardMemberFresh = Member::find($boardMember->id);

    Notification::assertSentTo($boardMemberFresh, \App\Notifications\NewMemberApplied::class);

    /**
     * , function ($notification, $channels) use ($boardMemberFresh, $member) {
     * dump('NewMemberApplied sent - To ID:', $boardMemberFresh->id, 'Member ID:', 'Channels:', $channels, '$boardMemberFresh->id === $member->id', $boardMemberFresh->id === $member->id);
     * return $boardMemberFresh->id != $member->id;
     * }
     *
     * ,function ($notification, $channels) use ($member) {
     * dump('ApplianceReceivedNotification sent - To ID:', $member->id, 'Member ID:', $notification->member->id, 'Channels:', $channels);
     * return $notification->member->id === $member->id;
     * }
     */
    Notification::assertSentTo($member, \App\Notifications\ApplianceReceivedNotification::class);

    $component->assertDispatched('toast-show', function ($event, $payload) {
        return $payload['dataset']['variant'] === 'success' &&
            $payload['slots']['text'] === __('members.apply.submission.success.msg') &&
            $payload['slots']['heading'] === __('members.apply.submission.success.head');
    });
});

test('store creates member without application with authorization', function () {
    $user = User::factory()
        ->create(['is_admin' => true]);
    $this->actingAs($user);
    \Illuminate\Support\Facades\Gate::define('create', fn ($user, $class) => true);

    $component = Livewire::test(Form::class)
        ->set('application', false)
        ->set('form.name', 'Jane Doe')
        ->set('form.email', 'jane@example.com')
        ->set('form.gender', \App\Enums\Gender::ma->value)
        ->set('form.birth_date', now()
            ->subYears(30)
            ->toDateString())
        ->set('form.family_status', \App\Enums\MemberFamilyStatus::NN->value)
        ->set('form.type', \App\Enums\MemberType::MD->value)
        ->set('form.country', 'Deutschland')
        ->call('store');

    $member = Member::latest()
        ->first();
    expect($member)->not->toBeNull();
    expect($member->name)->toBe('Jane Doe');

    $component->assertDispatched('toast-show', function ($event, $payload) {
        return $payload['dataset']['variant'] === 'success' &&
            $payload['slots']['text'] === __('members.apply.submission.success.msg') &&
            $payload['slots']['heading'] === __('members.apply.submission.success.head');
    });
    $component->assertRedirect(route('members.show', ['member' => $member]));
});


test('all translations are rendered', function () {

    $user = \App\Models\User::factory()
        ->create(['is_admin' => true]);
    $this->actingAs($user);

    $keys = [];
    $prefix = 'members.';
    foreach (\App\Enums\Locale::cases() as $locale) {
        $translations = require "lang/{$locale->value}/members.php";
        $keys = array_merge($keys, array_keys(Arr::dot($translations, $prefix)));
    }
    $component = Livewire::test(Form::class);

    foreach ($keys as $key) {
        if ($key !== $prefix) {
            $component->assertDontSee($key);
        }
    }
});
