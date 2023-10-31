<?php

namespace Database\Factories;

use App\Models\Artiste;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Artiste>
 */
class ArtisteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = Artiste::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()
        ];
    }
}
