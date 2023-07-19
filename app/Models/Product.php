<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Connection
    // protected $connection = 'mysql2';

    /**
     * Получить галлерею товара.
     */
    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }
}
