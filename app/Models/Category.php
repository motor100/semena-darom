<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'parent',
        'slug',
        'image',
        'count_children',
        'sort',
    ];

    /**
     * Поиск модели по slug
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
