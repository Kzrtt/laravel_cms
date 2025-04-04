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
        Schema::create('products', function (Blueprint $table) {
            $table->increments('prd_id');
            $table->string('prd_name', 50);
            $table->string('prd_description', 255);
            
            $table->unsignedInteger('brands_brd_id')->nullable();
            $table->unsignedInteger('measurement_units_msu_id')->nullable();

            $table->foreign('brands_brd_id')->references('brd_id')->on('brands')->onDelete('set null');
            $table->foreign('measurement_units_msu_id')->references('msu_id')->on('measurement_units')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
