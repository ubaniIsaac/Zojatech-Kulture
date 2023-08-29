<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\User */

class UserResources extends JsonResource
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
            'type' => 'users',
            'attributes' => [
                'username' => $this->username,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'profile_picture' => $this->profile_picture,
                'streaming_limit' => $this->streaming_limit,
                'referral_code' => $this->referral_code,
                'referred_by' => $this->referred_by,
                'referral_link' => $this->referral_link,
                'user_type' => $this->user_type,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],

            'subscription_id' => $this->subscription_id,
        ];
    }
}
