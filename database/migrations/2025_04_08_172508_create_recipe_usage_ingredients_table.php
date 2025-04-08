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
        Schema::create('recipe_usage_ingredients', function (Blueprint $table) {
            $table->increments('rui_id');
            $table->decimal('rui_total');
            $table->integer('rui_quantity');

            $table->unsignedInteger('recipe_ingredient_rei_id');
            $table->unsignedInteger('recipe_usage_reu_id');

            $table->foreign('recipe_ingredient_rei_id')->references('rei_id')->on('recipe_ingredients');
            $table->foreign('recipe_usage_reu_id')->references('reu_id')->on('recipe_usages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe_usage_ingredients');
    }
};
