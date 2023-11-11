<?php

namespace Database\Factories;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MovieGenreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'movie_id' => Movie::factory(),
            'genre_id' => Genre::factory(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Movie $movie) {
            $genres = Genre::factory()->count(rand(1, 3))->create(); // create 1 to 3 genres

            // the logic depends on your relationship type, given it's many-to-many, I'm using the attach method
            $movie->genres()->attach($genres);
        });
    }
}
