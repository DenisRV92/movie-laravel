<?php

namespace App\Services;

use App\Models\Movie;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewService implements ReviewServiceInterface
{
    /**
     * @param Request $request
     * @param Movie $movie
     * @return Movie[]
     */
    public function store(Request $request, Movie $movie): array
    {
        $review = new Review;
        $review->message = $request->input('message');
        $review->user_id = Auth::id();
        $review->save();

        $movie->reviews()->attach($review->id);

        $response = ['movie' => $movie];
        return $response;
    }

    /**
     * @param int $userId
     * @return array
     */
    public function myReviews(int $userId): array
    {
        $user = auth()->user($userId);
        $reviews = $user->reviews;

        $response = ['reviews' => $reviews];
        return $response;
    }
}
