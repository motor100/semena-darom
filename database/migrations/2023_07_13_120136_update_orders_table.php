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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('first_name');
            $table->string('last_name');
            $table->bigInteger('phone')->unsigned();
            $table->string('email');
            $table->integer('price');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('status');
            $table->string('comment')->nullable();
            $table->tinyInteger('payment')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
