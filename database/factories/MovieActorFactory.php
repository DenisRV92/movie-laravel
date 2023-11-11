<?php

namespace Database\Factories;

use App\Models\Actor;
use App\Models\Movie;
use App\Models\MovieActor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MovieActorFactory extends Factory
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
            'actor_id' => Actor::factory(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (MovieActor $movieActor) {
            $actors = Actor::factory()->count(rand(1, 3))->create();

            $movie = Movie::find($movieActor->movie_id);

            if ($movie) {
                $movie->actors()->attach($actors);
            }
        });
    }
}
