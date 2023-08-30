<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavouriteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        
        return [
            'id' =>strval($this->id),
            'name' => $this->name,
            'genre' => $this->genre,
            'imageUrl' => json_decode($this->imageUrl),
            'price' => $this->price,
            'fileUrl' => json_decode($this->fileUrl)
        ];
    }
}
