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
        Schema::create('user_represented_agents', function (Blueprint $table) {
            $table->increments('ura_id');
            $table->string('ura_type', 50);
            $table->unsignedInteger('represented_agent_id');
            $table->unsignedInteger('users_usr_id');

            $table->foreign('users_usr_id')->references('usr_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_represented_agents');
    }
};
