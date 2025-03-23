<?php

test('example', function () {
    $response = $this->get('/events/');

    $response->assertStatus(200);
});
