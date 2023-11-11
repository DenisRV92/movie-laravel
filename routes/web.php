<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('admin.index');
    });
    Route::get('/favorite',[MovieController::class,'myMovies'])->name('my_movies');
    Route::get('/review',[ReviewController::class,'myReview'])->name('my_reviews');
    Route::get('/movies/{movie}/edit', [MovieController::class,'edit'])->name('admin.movies.edit');
    Route::patch('/movies/{movie}', [MovieController::class,'update'])->name('admin.movies.update');

});

Route::get('/', function () {
    return  redirect('/movie');
});

Route::prefix('movie')->group(function () {
    Route::get('/', [MovieController::class, 'index']);
    Route::get('/add-favorite/{movie}', [MovieController::class, 'addFavorite']);
    Route::get('/delete-favorite/{movie}', [MovieController::class, 'deleteFavorite']);
    Route::get('/{genre}/{movie:slug}', [MovieController::class, 'show'])->name('show');
    Route::post('/', [MovieController::class, 'getMovieToGenre']);
    Route::post('/filter', [MovieController::class, 'filter'])->name('filter');
});

Route::post('/review/{movie}', [ReviewController::class, 'store']);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
