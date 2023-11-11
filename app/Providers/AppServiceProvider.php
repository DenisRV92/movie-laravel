<?php

namespace App\Providers;

use App\Models\Review;
use App\Policies\ReviewPolicy;
use App\Services\MovieService;
use App\Services\MovieServiceInterface;
use App\Services\ReviewService;
use App\Services\ReviewServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Review::class => ReviewPolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(MovieServiceInterface::class, MovieService::class);
        $this->app->bind(ReviewServiceInterface::class, ReviewService::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
