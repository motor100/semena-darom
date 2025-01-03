<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cdek_orders', function (Blueprint $table) {
            $table->uuid('cdek_pvz_uuid')->after('order_id'); // uuid пункта выдачи заказов ПВЗ СДЕК
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('cdek_pvz_uuid');
        });
    }
};
