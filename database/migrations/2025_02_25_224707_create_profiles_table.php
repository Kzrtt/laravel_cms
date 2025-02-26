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
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('prf_id');
            $table->string('prf_name', 255);
            $table->timestamp('prf_created_at')->useCurrent();
            $table->timestamp('prf_updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->boolean('prf_status')->default(true);
            $table->string('prf_level', 50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
