<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class GenreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $uniqueGenres = [];
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Xylis\FakerCinema\Provider\Movie($faker));

        do {
            $genre = $faker->movieGenre;
        } while (in_array($genre, $uniqueGenres));


        $uniqueGenres[] = $genre;
        return [
            'name' => $genre,
        ];
    }
}
