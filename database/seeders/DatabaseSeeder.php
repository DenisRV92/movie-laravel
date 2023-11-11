<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\ActorFactory;
use Database\Factories\DirectorFactory;
use Database\Factories\GenreFactory;
use Database\Factories\MovieActorFactory;
use Database\Factories\MovieDirectorFactory;
use Database\Factories\MovieFactory;
use Database\Factories\MovieGenreFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $directors = DirectorFactory::new()->count(30)->create();
        $genres = GenreFactory::new()->count(20)->create();
        $actors = ActorFactory::new()->count(30)->create();

        MovieFactory::new()->count(30)->create()->each(function ($movie, $index) use ($actors, $genres, $directors) {
            $movie->actors()->attach($actors->random(rand(1, 3)));
            $movie->genres()->attach($genres->random(rand(1, 3)));
            $movie->directors()->attach($directors[$index]->id);
        });

    }

}
