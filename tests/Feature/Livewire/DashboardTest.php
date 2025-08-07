<?php

declare(strict_types=1);

it('can see applicant widget', function (): void {

    $user = \App\Models\User::factory()->create(['is_admin' => true]);
    $response = $this->actingAs($user)->get(route('dashboard'))->assertStatus(200);

});
