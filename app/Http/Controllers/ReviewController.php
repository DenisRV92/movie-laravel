<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Review;
use App\Services\ReviewServiceInterface;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    private $reviewService;

    public function __construct(ReviewServiceInterface $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    public function store(Request $request, Movie $movie)
    {
        try {
            $this->authorize('store', Review::class);
            $response = $this->reviewService->store($request, $movie);
            return view('movie.review', $response);
        } catch (Exception $e) {
            return response()->json(['error' => 'Пользователь не авторизован'], 401);
        }
    }

    public function myReview()
    {
        $response = $this->reviewService->myReviews(Auth::id());
        return view('admin.review', $response);
    }


}
