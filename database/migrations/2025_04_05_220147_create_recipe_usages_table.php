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
        Schema::create('recipe_usages', function (Blueprint $table) {
            $table->increments('reu_id');
            $table->integer('reu_quantity');
            $table->timestamp('pur_created_at')->useCurrent();

            $table->unsignedInteger('recipe_rec_id');

            $table->foreign('recipe_rec_id')->references('rec_id')->on('recipes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe_usages');
    }
};
