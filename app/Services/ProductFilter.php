<?php

namespace App\Services;

class ProductFilter
{
    protected $builder;
    protected $request;

    public function __construct($builder, $request)
    {
        $this->builder = $builder;
        $this->request = $request;
    }

    public function apply()
    {
        foreach($this->filters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    public function category($value)
    {
        $category = \App\Models\Category::where('slug', $value)->first();

        if (!$category) return;

        // Если это родительская категория, то получаю дочерние категории и применяю в запросе whereIn для получения товаров
        if ($category->parent == 0) {
            $subcategory = \App\Models\Category::where('parent', $category->id)->pluck('id');
            $this->builder->whereIn('category_id', $subcategory);
        } else {
            // Если это дочерняя категория, то применяю в запросе where для получения товаров
            $this->builder->where('category_id', $category->id);
        }
    }

    public function price($value)
    {
        if ($value != "desc" && $value != "asc") return;

        $this->builder->orderBy('retail_price', $value);
    }

    public function filters()
    {
        return $this->request->all();
    }
}