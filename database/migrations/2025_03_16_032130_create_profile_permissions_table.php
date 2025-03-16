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
        Schema::create('profile_permissions', function (Blueprint $table) {
            $table->increments('prp_id');
            $table->string('prp_area', 255);
            $table->string('prp_action', 50);

            $table->unsignedInteger('profiles_prf_id');

            $table->foreign('profiles_prf_id')->references('prf_id')->on('profiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_permissions');
    }
};
