<?php

namespace App\Services;

use App\Models\Movie;
use Illuminate\Http\Request;

interface ReviewServiceInterface
{
    public function store(Request $request, Movie $movie): array;

    public function myReviews(int $userId): array;
}
