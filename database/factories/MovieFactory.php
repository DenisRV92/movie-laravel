<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $uniqueMovies = [];
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Xylis\FakerCinema\Provider\Movie($faker));

        do {
            $movie = $faker->movie;
            $galleryImages = range(1, 5);
            foreach ($galleryImages as $i => $value) {
                $galleryImages[$i] = $faker->imageUrl();
            }

        } while (in_array($movie, $uniqueMovies));
        $uniqueMovies[] = $movie;

        return [
            'title' => $movie,
            'slug' => Str::slug($movie),
            'year' => $faker->numberBetween($min = 1990, $max = 2023),
            'rating' => $faker->numberBetween($min = 5, $max = 10),
            'preview' => $faker->imageUrl(),
            'gallery' => $galleryImages,
        ];
    }
}
