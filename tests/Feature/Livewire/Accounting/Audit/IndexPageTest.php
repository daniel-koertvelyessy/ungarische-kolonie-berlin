<?php

declare(strict_types=1);

use App\Models\Membership\Member;
use App\Models\User;

it('can view the audit index page', function (): void {

    $this->actingAs(Member::factory()->withUser()->create(['user_id' => User::factory()->create(['email_verified_at' => now()])->id])->user);

    $response = $this->get(route('accounts.report.index'));

    $response->assertStatus(200);

});
