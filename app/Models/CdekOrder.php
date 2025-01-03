<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CdekOrder extends Model
{
    use HasFactory;

    /**
     * Таблица БД, ассоциированная с моделью.
     *
     * @var string
     */
    protected $table = 'cdek_orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'cdek_pvz_uuid',
        'cdek_order_uuid',
        'waybill_id',
        'waybill_uuid',        
    ];
}
