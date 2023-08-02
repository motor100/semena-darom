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
        // composer require doctrine/dbal
        Schema::table('cdek_orders', function (Blueprint $table) {
            $table->renameColumn('waybill_id', 'waybill_uuid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cdek_orders', function (Blueprint $table) {
            $table->renameColumn('waybill_uuid', 'waybill_id');
        });
    }
};
