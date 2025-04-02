<?php

it('can view the index page', function () {

    $this->actingAs(\App\Models\Membership\Member::factory()->create()->user);

    $response = $this->get(route('accounts.report.index'));

    $response->assertStatus(200);

});
