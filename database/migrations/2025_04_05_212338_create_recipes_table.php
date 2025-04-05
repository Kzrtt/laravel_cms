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
        Schema::create('recipes', function (Blueprint $table) {
            $table->increments('rec_id');
            $table->string('rec_name', 120);
            $table->text('rec_preparation');
            $table->time('rec_preparation_time');
            $table->integer('rec_portions');
            $table->timestamp('rec_created_at')->useCurrent();
            $table->timestamp('rec_updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
