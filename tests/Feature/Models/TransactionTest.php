<?php

declare(strict_types=1);

test('example', function () {
    $response = $this->get('/');

    \App\Models\Accounting\Transaction::factory()->count(10)->create();

    $response->assertStatus(200);
});
