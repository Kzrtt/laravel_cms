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
        Schema::create('purchase_products', function (Blueprint $table) {
            $table->increments('prc_id');
            $table->decimal('prc_unit_price');
            $table->integer('prc_quantity');
            $table->date('prc_due_date');

            $table->unsignedInteger('purchase_pur_id');
            $table->unsignedInteger('products_prd_id');

            $table->foreign('purchase_pur_id')->references('pur_id')->on('purchases');
            $table->foreign('products_prd_id')->references('prd_id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_products');
    }
};
