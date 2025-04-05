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
        Schema::create('purchases', function (Blueprint $table) {
            $table->increments('pur_id');
            $table->decimal('pur_total');
            $table->string('pur_name');
            $table->string('pur_location');
            $table->string('pur_payment_method');
            $table->timestamp('pur_created_at')->useCurrent();
            $table->timestamp('rec_updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unsignedInteger('suppliers_sup_id');
            $table->foreign('suppliers_sup_id')->references('sup_id')->on('suppliers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
