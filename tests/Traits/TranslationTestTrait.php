<?php

namespace Tests\Traits;

use App\Models\Membership\Member;
use Illuminate\Support\Arr;
use Livewire\Livewire;

trait TranslationTestTrait
{
    protected function assertTranslationsRendered($componentClass, $langFile, $prefix, ...$mountParams): void
    {
        $user = \App\Models\User::factory()
            ->create(['is_admin' => true]);
        $this->actingAs($user);

        $member = Member::factory()->create(['user_id' => $user->id]);

        $component = Livewire::test($componentClass);

        if (! empty($mountParams)) {
            dump($mountParams); // Zeigt [$eventId]
            $component->call('mount', ...$mountParams); // Wird zu mount($eventId)
        }

        //        $component = Livewire::test($componentClass)->call('mount', ...$mountParams);
        //
        //        $component = Livewire::test($componentClass);

        if (! empty($mountParams)) {
            $component->call('mount', ...$mountParams);
        }

        $keys = [];
        foreach (\App\Enums\Locale::cases() as $locale) {
            $translations = require "lang/{$locale->value}/{$langFile}";
            $keys = array_merge($keys, array_keys(Arr::dot($translations, $prefix)));
        }

        foreach ($keys as $key) {
            if ($key !== $prefix) {
                $component->assertDontSee($key);
            }
        }
    }
}
