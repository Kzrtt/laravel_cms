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
        Schema::create('persons', function (Blueprint $table) {
            $table->increments('pes_id');
            $table->string('pes_name', 255);
            $table->string('pes_email', 255)->unique();
            $table->string('pes_cpf', 14)->unique();
            $table->timestamp('pes_created_at')->useCurrent();
            $table->timestamp('pes_updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->string('pes_street', 255)->nullable();
            $table->string('pes_number', 10)->nullable();
            $table->string('pes_complement', 255)->nullable();
            $table->string('pes_neighborhood', 255)->nullable();
            $table->string('pes_postal_code', 20)->nullable();
            $table->string('pes_phone', 20)->nullable();
            $table->unsignedInteger('city_cit_id')->nullable();

            // FK city_cit_id referencing city(cit_id)
            $table->foreign('city_cit_id')->references('cit_id')->on('city')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persons');
    }
};
