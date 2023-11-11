<?php


namespace App\Http\Filters;


class MovieFilter extends QueryFilter
{
    public function releaseDateBefore(int $year)
    {
        $this->builder->where('year', '>=', $year);
    }

    public function releaseDateAfter(int $year)
    {
        $this->builder->where('year', '<=', $year);
    }

    public function ratingFrom(int $rating)
    {
        $this->builder->where('rating', '>=', $rating);
    }

    public function ratingTo(int $rating)
    {
        $this->builder->where('rating', '<=', $rating);
    }

    public function actors(array $actorIds)
    {
        $this->builder->whereHas('actors', function ($query) use ($actorIds) {
            $query->whereIn('actors.id', $actorIds);
        });
    }

    public function directors(?int $directorId)
    {
        if (!is_null($directorId)) {
            $this->builder->whereHas('directors', function ($query) use ($directorId) {
                $query->where('directors.id', $directorId);
            });
        }
    }

    public function sortByDate($order = 'asc')
    {
        $this->builder->orderBy('year', $order);
    }

    public function sortByRating($order = 'asc')
    {
        $this->builder->orderBy('rating', $order);
    }

    public function search($string)
    {
        $this->builder->where('title', 'ilike', "%{$string}%");
    }

}
