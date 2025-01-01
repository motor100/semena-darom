<?php

namespace App\Services;

class Slug
{
    protected $builder;
    protected $slug;
    
    /**
     * @param Illuminate\Database\Eloquent\Builder $builder
     * @param string $slug
     */
    public function __construct($builder, $slug)
    {
        $this->builder = $builder;
        $this->slug = $slug;
    }

    /**
     * Проверка на уникальный slug
     * 
     * @param
     * @return string
     */
    public function check(): string
    {
        $have_slug = $this->builder->where('slug', $this->slug)->get();

        if (count($have_slug) > 0) {
            $newslug = $this->slug . '-%';
            $slugs = $this->builder->where('slug', 'like', $newslug)->get();

            $count_slugs = count($slugs) + 1;
            $this->slug = $this->slug . '-' . $count_slugs;
        }

        return $this->slug;
    }
}