<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


abstract class QueryFilter
{
    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @var Builder
     */
    protected Builder $builder;

    /**
     * @var array
     */
    protected array $fields;

      /**
     * QueryFilter constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->setFields(array_map(function ($item) {
            return is_string($item) ? trim($item) : $item;
        }, $this->request->all()));
    }

    /**
     * @param Builder $builder
     */
    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->fields() as $field => $value) {
            $method = Str::camel($field);
            if (method_exists($this, $method)) {
                call_user_func([$this, $method], $value);
            }
        }
    }


    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }


    /**
     * @param array $fields
     * @return $this
     */
    public function setFields(array $fields): static
    {
        $this->fields = $fields;
        return $this;
    }

    /**
     * @return array
     */
    public function fields(): array
    {
        return $this->fields;
    }
}
