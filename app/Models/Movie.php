<?php

namespace App\Models;

use App\Http\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Movie extends Model
{
    use HasFactory;

    protected $table = 'movies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title', 'slug', 'year', 'rating', 'preview', 'gallery'];
    protected $casts = [
        'gallery' => 'array',
    ];

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'movie_genre');
    }

    public function actors()
    {
        return $this->belongsToMany(Actor::class, 'movie_actor');
    }

    public function directors()
    {
        return $this->belongsToMany(Director::class, 'movie_director');
    }

    public function reviews()
    {
        return $this->belongsToMany(Review::class, 'movie_review');
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'movie_user');
    }

    /**
     * @param Builder $builder
     * @param QueryFilter $filter
     */
    public function scopeFilter(Builder $builder, QueryFilter $filter)
    {
        $filter->apply($builder);
    }
}
