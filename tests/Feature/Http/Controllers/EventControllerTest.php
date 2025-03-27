<?php

use App\Models\Event\EventSubscription;

test('generate ics', function () {
    $event = \App\Models\Event\Event::factory()->create();

    $response = $this->get('/events/ics/'.$event->slug['de']);
    $response->assertStatus(200)
        ->assertHeader('Content-Type', 'text/calendar; charset=UTF-8');

});

test('confirm subscription', function () {
    $evs = EventSubscription::factory()->create();

    $token = 'event_subscription_'.$evs->id.'_token';

    Cache::put("event_subscription_{$evs->id}_token", $token, now()->addMinutes(10));

    $response = $this->get('/events/subscription/confirm/'.$evs->id.'/'.$token);
    $response->assertStatus(200);

    $evs->refresh();

    expect($evs->confirmed_at)->not->toBeNull();

});

test('index', function () {
    $response = $this->get('/events');

    $response->assertStatus(200)
        ->assertViewIs('events.index');
});

test('show', function () {
    $event = \App\Models\Event\Event::factory()->create();

    $response = $this->get('/events/'.$event->slug['de']);

    $response->assertStatus(200)
        ->assertViewIs('events.show');

});
