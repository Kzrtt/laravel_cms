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
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('adm_id');
            $table->string('adm_fantasy', 255);
            $table->string('adm_cnpj', 18);
            // BOOLEAN DEFAULT 0 => em Laravel, usamos boolean com ->default(false)
            $table->boolean('adm_super')->default(false);
            $table->string('adm_email', 255);
            $table->string('adm_phone', 20)->nullable();
            $table->string('adm_number', 10)->nullable();
            $table->string('adm_street', 255)->nullable();
            $table->string('adm_complement', 255)->nullable();
            $table->string('adm_neighborhood', 255)->nullable();
            $table->string('adm_postal_code', 20)->nullable();

            // Timestamps customizados (adm_created_at e adm_updated_at)
            $table->timestamp('adm_created_at')->useCurrent();
            // useCurrentOnUpdate() faz o mesmo papel do ON UPDATE CURRENT_TIMESTAMP
            $table->timestamp('adm_updated_at')->useCurrent()->useCurrentOnUpdate();

            // city_cit_id
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
        Schema::dropIfExists('admins');
    }
};
