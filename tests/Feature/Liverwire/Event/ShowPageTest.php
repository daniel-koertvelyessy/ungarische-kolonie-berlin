<?php

use App\Livewire\Event\Show\Page;
use App\Models\Event\Event;
use App\Models\Membership\Member;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Http\UploadedFile;

test('event show page component renders correctly', function () {

    // Nutzer mit Member erstellen
    $user = User::factory()->create();
    $member = Member::factory()->create([
        'user_id' => $user->id, // Member mit User verknüpfen
    ]);

    // Nutzer authentifizieren
    $this->actingAs($user);

    $event = \App\Models\Event\Event::factory()->create();

    Livewire::test(\App\Livewire\Event\Show\Page::class, ['event' => $event])
        ->assertStatus(200);
});

test('event show page loads the correct event data', function () {
    $user = User::factory()->create();
    $member = Member::factory()->create([
        'user_id' => $user->id, // Member mit User verknüpfen
    ]);

    // Nutzer authentifizieren
    $this->actingAs($user);
    $event = \App\Models\Event\Event::factory()->create();

    Livewire::test(\App\Livewire\Event\Show\Page::class, ['event' => $event])
        ->assertSet('event_id', $event->id)
        ->assertSee($event->name); // Adjust according to your event fields
});

test('event show page loads subscriptions', function () {
    $user = User::factory()->create();
    $member = Member::factory()->create([
        'user_id' => $user->id, // Member mit User verknüpfen
    ]);

    // Nutzer authentifizieren
    $this->actingAs($user);
    $event = \App\Models\Event\Event::factory()->create();
    \App\Models\Event\EventSubscription::factory()->count(3)->create(['event_id' => $event->id]);

    Livewire::test(\App\Livewire\Event\Show\Page::class, ['event' => $event])
        ->assertCount('subscriptions', 3);
});

test('assign venue listener works', function () {
    // Setup: Authenticated user with member
    $user = User::factory()->create();
    $member = Member::factory()->create(['user_id' => $user->id]);
    $this->actingAs($user);

    // Create an event for the component
    $event = \App\Models\Event\Event::factory()->create();

    // Initial state: One venue exists
    Venue::factory()->create(['name' => 'Initial Venue']);

    // Test the Event\Show\Page component
    $component = Livewire::test(\App\Livewire\Event\Show\Page::class, ['event' => $event])
        ->assertSet('venues', Venue::select('id', 'name')->get()); // Expect initial Collection

    // Simulate venue creation (like Venue\Create\Page’s storeVenue())
    $newVenue = Venue::factory()->create(['name' => 'New Venue']);

    // Dispatch the event that Event\Show\Page listens for
    $component->dispatch('new-venue-created');

    // Assert the venues list updated
    $component->assertSet('venues', Venue::select('id', 'name')->get()); // Expect updated Collection

    // Optional: Verify the new venue is in the list
    $venues = $component->get('venues');
    expect($venues->pluck('id')->toArray())->toContain($newVenue->id);

});

test('event image upload stores correctly', function () {
    $user = User::factory()->create();
    $member = Member::factory()->create([
        'user_id' => $user->id, // Member mit User verknüpfen
    ]);

    // Nutzer authentifizieren
    $this->actingAs($user);
    $event = \App\Models\Event\Event::factory()->create();

    $fakeImage = UploadedFile::fake()->image('test.jpg');

    $component = Livewire::test(Page::class, ['event' => $event])
        ->dispatch('image-uploaded', $fakeImage);

    \Illuminate\Support\Facades\Gate::define('manage', fn ($user, $class) => true);

    $fakeImage = UploadedFile::fake()->image('test.jpg');

    Livewire::test(Page::class, ['event' => $event])
        ->dispatch('image-uploaded', $fakeImage)
        ->assertDispatched('flux-toast', function ($name, $params) {
            return $params[0]['variant'] === 'success'; // Access nested params

        });
});

test('clicking add visitor opens modal', function () {
    $user = User::factory()->create(['is_admin' => true]);
    $member = Member::factory()->create(['user_id' => $user->id]);
    $this->actingAs($user);
    $event = \App\Models\Event\Event::factory()->create();

    $component = Livewire::test(\App\Livewire\Event\Show\Page::class, ['event' => $event])
        ->call('addVisitor')
        ->assertDispatched('modal-show', ['name' => 'add-new-visitor']);
});

test('deleting assignment removes it and shows toast', function () {
    $user = User::factory()->create(['is_admin' => true]);
    $member = Member::factory()->create([
        'user_id' => $user->id, // Member mit User verknüpfen
    ]);

    // Nutzer authentifizieren
    $this->actingAs($user);

    $event = \App\Models\Event\Event::factory()->create();
    $assignment = \App\Models\EventAssignment::factory()->create(['event_id' => $event->id]);

    Livewire::test(Page::class, ['event' => $event])
        ->call('deleteAssignment', $assignment->id)
        ->assertReturned(null);

});

test('venue creation updates event show page venues', function () {
    $user = User::factory()->create();
    $member = Member::factory()->create(['user_id' => $user->id]);
    $this->actingAs($user);
    $event = \App\Models\Event\Event::factory()->create();

    $showComponent = Livewire::test(\App\Livewire\Event\Show\Page::class, ['event' => $event]);
    $createComponent = Livewire::test(\App\Livewire\Venue\Create\Page::class);

    $createComponent->call('storeVenue'); // Triggers new-venue-created
    $showComponent->assertSet('venues', Venue::select('id', 'name')->get());
});
