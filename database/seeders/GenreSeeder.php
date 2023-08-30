<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $genres = [
        //     ['name' => 'Hip Hop'],
        //     ['name' => 'Afrobeat'],
        //     ['name' => 'Rock'],
        // ];

        // DB::table('genres')->insert($genres);

        Genre::factory()->count(3)
            ->create();
    }
}
