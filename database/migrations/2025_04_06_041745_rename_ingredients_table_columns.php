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
        Schema::table('ingredients', function (Blueprint $table) {
            $table->renameColumn('prd_id', 'ing_id');
            $table->renameColumn('prd_name', 'ing_name');
            $table->renameColumn('prd_description', 'ing_description');
            $table->renameColumn('prd_current_stock', 'ing_current_stock');
            $table->renameColumn('prd_min_stock', 'ing_min_stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ingredients', function (Blueprint $table) {
            $table->renameColumn('ing_id', 'prd_id');
            $table->renameColumn('ing_name', 'prd_name');
            $table->renameColumn('ing_description', 'prd_description');
            $table->renameColumn('ing_current_stock', 'prd_current_stock');
            $table->renameColumn('ing_min_stock', 'prd_min_stock');
        });
    }
};
