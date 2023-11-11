<?php

namespace App\Http\Controllers;

use App\Http\Filters\MovieFilter;
use App\Models\Actor;
use App\Models\Director;
use App\Models\Genre;
use App\Models\Movie;
use App\Services\MovieService;
use App\Services\MovieServiceInterface;
use Illuminate\Http\Request;
use Exception;

class MovieController extends Controller
{
    protected $movieService;

    public function __construct(MovieServiceInterface $movieService)
    {
        $this->movieService = $movieService;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data = $this->movieService->getAll();
        return view('welcome', $data);
    }

    /**
     * @param $genre
     * @param Movie $movie
     * @return \Illuminate\View\View
     */
    public function show($genre, Movie $movie)
    {
        $data = $this->movieService->showMovie($genre, $movie);
        return view('movie.detail', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getMovieToGenre(Request $request)
    {
        $data = $this->movieService->getMovieToGenre($request);
        return response()->view('movies', $data);
    }

    /**
     * @param MovieFilter $filter
     * @return \Illuminate\Http\Response
     */
    public function filter(MovieFilter $filter)
    {
        $data = $this->movieService->filterMovies($filter);
        return response()->view('movies', $data);
    }

    /**
     * @param Movie $movie
     * @return \Illuminate\Http\JsonResponse
     */
    public function addFavorite(Movie $movie)
    {
        $responseData = $this->movieService->addMovieToUserFavorite($movie);
        return response()->json($responseData, isset($responseData['error']) ? 404 : 200);
    }

    /**
     * @param Movie $movie
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteFavorite(Movie $movie)
    {
        $responseData = $this->movieService->removeMovieFromUserFavorite($movie);
        return response()->json($responseData, isset($responseData['error']) ? 404 : 200);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function myMovies()
    {
        $data = $this->movieService->getMyMovies();
        return view('admin.movies', $data);
    }

    /**
     * @param Movie $movie
     * @return \Illuminate\View\View
     */
    public function edit(Movie $movie)
    {
        $data = $this->movieService->getMovieForEditing($movie);
        return view('admin.edit', $data);
    }

    /**
     * @param Movie $movie
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function update(Movie $movie, Request $request)
    {
        $data = $this->movieService->updateMovie($movie, $request);
        return view('admin.edit', $data);
    }

}
