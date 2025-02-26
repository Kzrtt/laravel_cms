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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('usr_id');
            $table->string('usr_email', 255)->unique();
            $table->string('usr_password', 255);
            $table->string('usr_level', 50);
            $table->timestamp('usr_created_at')->useCurrent();
            $table->timestamp('usr_updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unsignedInteger('persons_pes_id');
            $table->unsignedInteger('profiles_prf_id');

            // FKs
            $table->foreign('persons_pes_id')->references('pes_id')->on('persons')->onDelete('cascade');
            $table->foreign('profiles_prf_id')->references('prf_id')->on('profiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
