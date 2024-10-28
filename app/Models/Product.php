<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'image',
        'text_json',
        'text_html',
        'barcode',
        'stock',
        'buying_price',
        'wholesale_price',
        'retail_price',
        'promo_price',
        'weight',
        'brand',
        'property',
        'position',
    ];

    /**
     * Получить категорю товара.
     * Один к одному обратное соотношение
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Получить галерею товара.
     */
    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    /**
     * Поиск модели по slug
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
