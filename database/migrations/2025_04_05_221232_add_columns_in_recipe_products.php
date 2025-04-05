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
        Schema::table('recipe_products', function (Blueprint $table) {
            $table->integer('rep_quantity');

            $table->unsignedInteger('measurement_unit_msu_id');

            $table->foreign('measurement_unit_msu_id')->references('msu_id')->on('measurement_units');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recipe_products', function (Blueprint $table) {
            $table->dropForeign(['measurement_unit_msu_id']);
            $table->dropColumn(['rep_quantity', 'measurement_unit_msu_id']);
        });
    }
};
