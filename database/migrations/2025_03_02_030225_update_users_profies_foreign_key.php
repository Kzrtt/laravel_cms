<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove a constraint antiga da foreign key
            $table->dropForeign(['profiles_prf_id']);
            
            // Recria a foreign key com a regra onDelete('restrict')
            $table->foreign('profiles_prf_id')
                    ->references('prf_id')->on('profiles')
                    ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove a constraint com onDelete('restrict')
            $table->dropForeign(['profiles_prf_id']);
            
            // Recria a foreign key com o comportamento anterior (cascade)
            $table->foreign('profiles_prf_id')
                    ->references('prf_id')->on('profiles')
                    ->onDelete('cascade');
        });
    }
};
