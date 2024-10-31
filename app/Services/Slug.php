<?php

namespace App\Services;

class Slug
{
    protected $model;
    protected $slug;

    public function __construct($model, $slug)
    {
        $this->model = $model;
        $this->slug = $slug;
    }

    public function check()
    {
        // Проверка на уникальный slug
        $have_slug = $this->model->where('slug', $this->slug)
                            ->get();
        if (count($have_slug) > 0) {
            $newslug = $this->slug . '-%';
            $slugs = $this->model->where('slug', 'like', $newslug)
                            ->get();
            $count_slugs = count($slugs) + 1;
            $this->slug = $this->slug . '-' . $count_slugs;
        }

        return $this->slug;
    }
}