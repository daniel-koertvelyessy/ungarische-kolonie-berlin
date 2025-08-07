<?php

declare(strict_types=1);

use App\Enums\MemberType;

test('A list of applicant can be seen', function (): void {
    $applicants = \App\Models\Membership\Member::factory()->count(10)->create([
        'type' => MemberType::AP->value,
    ]);

    $component = Livewire::test(\App\Livewire\Dashboard\Widgets\Applicants::class)
        ->assertSeeHtml('<aside class="flex items-center gap-3">');

});

test('all translations are rendered', function (): void {

    $user = \App\Models\User::factory()
        ->create(['is_admin' => true]);
    $this->actingAs($user);

    $keys = [];
    $prefix = 'members.';
    foreach (\App\Enums\Locale::cases() as $locale) {
        $translations = require "lang/{$locale->value}/members.php";
        $keys = array_merge($keys, array_keys(Arr::dot($translations, $prefix)));
    }

    $component = Livewire::test(\App\Livewire\Dashboard\Widgets\Applicants::class);

    foreach ($keys as $key) {
        if ($key !== $prefix) {
            $component->assertDontSee($key);
        }
    }

});
