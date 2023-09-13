<?php

namespace Tests\Feature\Authentication;

use Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

it('Register User', function () {
    $userType = array_rand(['artiste' => 'artiste', 'producer' => 'producer']); 

    $data = [
        'username' => fake()->name(),
        'email' => fake()->email(),
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'user_type' => $userType, 
        'password' => 'RashForddd',
        'confirm_password' => 'RashForddd',
    ];

    $response = $this->postJson(route('register', $data));

    // Assertions
    $response->assertStatus(201);
    expect($response['message'])->toBe('User created successfully');

    // Check for the presence of 'user' key in the response JSON
    if ($response->json('data.user')) {
        $user = $response->json('data.user');
        expect($user)->toBeArray();

        // Check if 'id' key exists and is not null
        if (array_key_exists('id', $user)) {
            $this->assertNotNull($user['id']);
        }

        // Conditional actions based on user_type
        if ($userType === 'artiste') {
            $this->assertDatabaseHas('artistes', [
                'user_id' => $user['id'],
            ]);
            $this->assertDatabaseHas('carts', [
                'user_id' => $user['id'],
            ]);
        } elseif ($userType === 'producer') {
            $this->assertDatabaseHas('producers', [
                'user_id' => $user['id'],
            ]);
        }

        $this->assertDatabaseHas('users', [
            'username' => $data['username'],
            'email' => $data['email'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'user_type' => $userType,
        ]);
    } else {
        $this->fail('Response JSON is empty or does not match expectations');
    }
});

