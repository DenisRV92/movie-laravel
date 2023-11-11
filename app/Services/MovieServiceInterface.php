<?php

namespace App\Services;

use App\Http\Filters\MovieFilter;
use App\Models\Movie;
use Illuminate\Http\Request;

interface MovieServiceInterface
{
    public function getAll();

    public function showMovie($genre, Movie $movie);

    public function getMovieToGenre(Request $request);

    public function filterMovies(MovieFilter $filter);

    public function addMovieToUserFavorite(Movie $movie);

    public function removeMovieFromUserFavorite(Movie $movie);

    public function getMyMovies();

    public function getMovieForEditing(Movie $movie);

    public function updateMovie(Movie $movie, Request $request);
}
