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
        Schema::table('recipe_ingredients', function (Blueprint $table) {
            $table->renameColumn('rep_id', 'rei_id');
            $table->renameColumn('rep_quantity', 'rei_quantity');
            $table->renameColumn('products_prd_id', 'ingredients_ing_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recipe_ingredients', function (Blueprint $table) {
            $table->renameColumn('rei_id', 'rec_id');
            $table->renameColumn('rei_quantity', 'rec_quantity');
            $table->renameColumn('ingredients_ing_id', 'products_prd_id');
        });
    }
};
