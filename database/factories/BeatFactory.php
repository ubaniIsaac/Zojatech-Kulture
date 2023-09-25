<?php

use App\Models\Beat;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class BeatFactory extends Factory
{
    protected $model = Beat::class;

    public function definition()
    {
        // Define the file path for a sample audio file
        $audioFile = UploadedFile::fake()->create('audio.mp3', 1000);

        // Define the file path for a sample image file (optional)
        $imageFile = UploadedFile::fake()->image('image.jpg');

        return [
            'name' => $this->faker->word,
            'audio' => $this->faker->url,
            'price' => $this->faker->randomFloat(2, 1, 100),
            'genre' => $this->faker->word, // Assuming 'genre' is a string field
            'image' => $imageFile ? 'images/' . $imageFile->name : null,
            'license_type' => $this->faker->word,
            'available_copies' => $this->faker->numberBetween(1, 100),
        ];
    }
}
