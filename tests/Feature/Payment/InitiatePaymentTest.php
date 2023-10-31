<?php

use App\Models\Beat;
use App\Helper\Helper;
use App\Services\PaymentService;
use Mockery\MockInterface;


beforeEach(function () {
    
  

});

it('initiates a transaction', function () {
    $user = actingAs();

    $event = Beat::factory()->create();
    $reference = uniqid();
    $data = [
        'amount' => fake()->numberBetween(100, 500),
        'event_id' => $event->id,
        'user_id'=> $user?->id,
        'ticket_type' => 'general',
        'quantity' => 2,
        'reference' => $reference
    ];
    

    $response = $this->postJson(route('pay'), $data);
    $response->assertStatus(200);

    $this->assertDatabaseCount('payments',1);
    $this->assertDatabaseCount('events',1);

    $this->assertDatabaseHas('payments', [
        'amount' => $data['amount'] * 100 * $data['quantity'],
        'event_id' => $data['event_id'],
        'user_id' => $data['user_id'],
        'ticket_type' => $data['ticket_type'],
        'quantity' => $data['quantity'],
        'status'=> 'pending'
    ]);

    expect($response['status'])->toBeTruthy();
    expect($response['message'])->toBe("Payment initialized");


});
