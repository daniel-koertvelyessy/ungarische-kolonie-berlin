<?php

use App\Models\Event\EventSubscription;
use App\Models\Membership\Member;

beforeEach(function () {
    // Seed or setup any necessary data before each test
    $this->member = Member::factory()->create(); // Assumes you have a Member factory
});

it('renders the mailer-test route successfully', function () {

    Route::get('/mailer-test', [\App\Http\Controllers\TestingController::class, 'mailTest'])
        ->name('mail-tester');

    $response = $this->get('/mailer-test');

    $response->assertStatus(200)
        ->when(fn()=>app()->isLocal())
        ->assertViewIs('emails.invitation')
        ->assertViewHas('member', fn ($member) => $member->id === 1);


});

it('switches locale and redirects back', function () {
    // Simulate a previous page
    $this->get('/'); // Sets HTTP_REFERER

    $response = $this->get('/lang/hu');

    $response->assertStatus(302) // Redirect
    ->assertRedirect('/'); // Back to previous page
    expect(app()->getLocale())->toBe('hu');
    expect(session('locale'))->toBe('hu');
});

it('confirms event subscription with valid token', function () {
    // Create a subscription
    $subscription = EventSubscription::factory()->create(['confirmed_at' => null]);
    $token = 'valid-token';

    // Mock the cache
    Cache::shouldReceive('get')
        ->with("event_subscription_{$subscription->id}_token")
        ->once()
        ->andReturn($token);
    Cache::shouldReceive('forget')
        ->with("event_subscription_{$subscription->id}_token")
        ->once();

    // Hit the route
    $response = $this->get("/event-subscription/confirm/{$subscription->id}/{$token}");

    // Assert the response
    $response->assertStatus(200)
        ->assertViewIs('events.show')
        ->assertViewHas('event', $subscription->event)
        ->assertViewHas('locale', app()->getLocale())
        ->assertSessionHas('status', 'Deine Anmeldung wurde bestätigt! 🎉');

    // Assert the subscription was updated and cache cleared
    expect($subscription->fresh()->confirmed_at)->not->toBeNull();
});

it('aborts with 403 for invalid event subscription token', function () {
    $subscription = EventSubscription::factory()->create([
        'confirmed_at' => null,
    ]);
    $token = 'invalid-token';
    Cache::put("event_subscription_{$subscription->id}_token", 'valid-token', now()->addHour());

    $response = $this->get("/event-subscription/confirm/{$subscription->id}/{$token}");

    $response->assertStatus(403);
    expect($subscription->fresh()->confirmed_at)->toBeNull();
});
