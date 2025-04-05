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
        Schema::create('action_logs', function (Blueprint $table) {
            $table->increments('alg_id');
            $table->string('alg_model', 60);
            $table->string('alg_action', 20);
            $table->string('alg_description', 150);
            $table->string('alg_object', 255);
            $table->date('alg_date');
            $table->time('alg_time');
            $table->integer('alg_model_id');
            
            $table->unsignedInteger('users_usr_id');
            $table->foreign('users_usr_id')->references('usr_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('action_logs');
    }
};
