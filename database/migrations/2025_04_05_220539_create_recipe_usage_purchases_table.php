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
        Schema::create('recipe_usage_purchases', function (Blueprint $table) {
            $table->increments('rup_id');

            $table->unsignedInteger('purchase_pur_id');
            $table->unsignedInteger('recipe_usage_reu_id');

            $table->foreign('purchase_pur_id')->references('pur_id')->on('purchases');
            $table->foreign('recipe_usage_reu_id')->references('reu_id')->on('recipe_usages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe_usage_purchases');
    }
};
