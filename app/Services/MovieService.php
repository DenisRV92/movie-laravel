<?php

namespace App\Services;

use App\Http\Filters\MovieFilter;
use App\Models\Actor;
use App\Models\Director;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;
use Exception;

class MovieService implements MovieServiceInterface
{
    /**
     * @return array
     */
    public function getAll()
    {
        $movies = Movie::paginate(25);
        $genres = Genre::all()->pluck('name', 'id');
        $actors = Actor::all()->pluck('name', 'id');
        $directors = Director::all()->pluck('name', 'id');
        $user = auth()->user();

        return ['movies' => $movies, 'genres' => $genres, 'actors' => $actors, 'directors' => $directors, 'user' => $user];
    }

    /**
     * @param $genre
     * @param Movie $movie
     * @return Movie[]
     */
    public function showMovie($genre, Movie $movie)
    {
        return ['movie' => $movie];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getMovieToGenre(Request $request)
    {
        $genreIds = $request->input('genres');
        $movies = Movie::whereHas('genres', function ($query) use ($genreIds) {
            $query->whereIn('genre_id', $genreIds);
        })->paginate(25);
        $user = auth()->user();

        return ['movies' => $movies, 'user' => $user];
    }

    /**
     * @param MovieFilter $filter
     * @return array
     */
    public function filterMovies(MovieFilter $filter)
    {
        $movies = Movie::filter($filter)->paginate(25);
        $user = auth()->user();

        return ['movies' => $movies, 'user' => $user];
    }

    /**
     * @param Movie $movie
     * @return string[]
     */
    public function addMovieToUserFavorite(Movie $movie)
    {
        try {
            $user = auth()->user();
            $user->movies()->attach($movie->id);
            return ['message' => 'The movie has been added to favorite.'];
        } catch (Exception $e) {
            return ['error' => 'Ошибка'];
        }
    }

    /**
     * @param Movie $movie
     * @return string[]
     */
    public function removeMovieFromUserFavorite(Movie $movie)
    {
        try {
            $user = auth()->user();
            $user->movies()->detach($movie->id);
            return ['message' => 'The movie has been removed from favorite.'];
        } catch (Exception $e) {
            return ['error' => 'Ошибка'];
        }
    }

    /**
     * @return array
     */
    public function getMyMovies()
    {
        $user = auth()->user();
        $movies = Movie::whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        return ['movies' => $movies];
    }

    /**
     * @param Movie $movie
     * @return Movie[]
     */
    public function getMovieForEditing(Movie $movie)
    {
        return ['movie' => $movie];
    }

    /**
     * @param Movie $movie
     * @param Request $request
     * @return Movie[]
     */
    public function updateMovie(Movie $movie, Request $request)
    {
        if ($request->hasFile('preview')) {
            $data['preview'] = $request->file('preview')->store('public/previews');
        }

        if ($request->has('gallery')) {
            $data['gallery'] = array_map(function ($image) {
                return $image->store('public/gallery');
            }, (array)$request->file('gallery'));
        }

        $movie->update($data);

        return ['movie' => $movie];
    }
}
