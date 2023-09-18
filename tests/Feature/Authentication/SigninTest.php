<?php

use App\Models\User;

it('Login User', function () {

    $user = User::factory()->create([
        'password' => 'RashForddd',
    ]);

    $data = [
        'email' => $user->email,
        'password' => 'RashForddd',
    ];

    $response = $this->postJson(route('signin', $data));

    $response->assertStatus(200);
    expect($response['message'])->toBe('User logged in successfully');

    $this->assertArrayHasKey('data', $response->json());

    $token = $response->json('data');
    $this->assertNotEmpty($token);
});

