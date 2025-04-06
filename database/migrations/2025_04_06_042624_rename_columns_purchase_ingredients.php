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
        Schema::table('purchase_ingredients', function (Blueprint $table) {
            $table->renameColumn('prc_id', 'pui_id');
            $table->renameColumn('prc_unit_price', 'pui_price');
            $table->renameColumn('prc_quantity', 'pui_quantity');
            $table->renameColumn('prc_due_date', 'pui_due_date');
            $table->renameColumn('products_prd_id', 'ingredients_ing_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_ingredients', function (Blueprint $table) {
            $table->renameColumn('pui_id', 'prc_id');
            $table->renameColumn('pui_unit_price', 'prc_price');
            $table->renameColumn('pui_quantity', 'prc_quantity');
            $table->renameColumn('pui_due_date', 'prc_due_date');
            $table->renameColumn('ingredients_ing_id', 'products_prd_id');
        });
    }
};
