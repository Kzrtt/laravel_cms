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
        Schema::create('recipe_products', function (Blueprint $table) {
            $table->increments('rep_id');            
            $table->unsignedInteger('recipe_rec_id');
            $table->unsignedInteger('products_prd_id');

            $table->foreign('recipe_rec_id')->references('rec_id')->on('recipes');
            $table->foreign('products_prd_id')->references('prd_id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe_products');
    }
};
