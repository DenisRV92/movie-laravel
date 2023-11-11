<?php


namespace App\Http\Filters;


class MovieFilter extends QueryFilter
{
    /**
     * @param int $year
     * @return void
     */
    public function releaseDateBefore(int $year)
    {
        $this->builder->where('year', '>=', $year);
    }

    /**
     * @param int $year
     * @return void
     */
    public function releaseDateAfter(int $year)
    {
        $this->builder->where('year', '<=', $year);
    }

    /**
     * @param int $rating
     * @return void
     */
    public function ratingFrom(int $rating)
    {
        $this->builder->where('rating', '>=', $rating);
    }

    /**
     * @param int $rating
     * @return void
     */
    public function ratingTo(int $rating)
    {
        $this->builder->where('rating', '<=', $rating);
    }

    /**
     * @param array $actorIds
     * @return void
     */
    public function actors(array $actorIds)
    {
        $this->builder->whereHas('actors', function ($query) use ($actorIds) {
            $query->whereIn('actors.id', $actorIds);
        });
    }

    /**
     * @param int|null $directorId
     * @return void
     */
    public function directors(?int $directorId)
    {
        if (!is_null($directorId)) {
            $this->builder->whereHas('directors', function ($query) use ($directorId) {
                $query->where('directors.id', $directorId);
            });
        }
    }

    /**
     * @param $order
     * @return void
     */
    public function sortByDate($order = 'asc')
    {
        $this->builder->orderBy('year', $order);
    }

    /**
     * @param $order
     * @return void
     */
    public function sortByRating($order = 'asc')
    {
        $this->builder->orderBy('rating', $order);
    }

    /**
     * @param $string
     * @return void
     */
    public function search($string)
    {
        $this->builder->where('title', 'ilike', "%{$string}%");
    }

}
