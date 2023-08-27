<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'attributes' => [
                'relationships' => [
                    'user' => [
                        'user_id' => $this->user_id,
                        'beat_id' => $this->beat_id,
                        'cart_id' => $this->cart_id,
                        'quantity' => $this->quantity,
                        'price' => $this->price
                    ]
        ]
            ]
            ];
        }
}
