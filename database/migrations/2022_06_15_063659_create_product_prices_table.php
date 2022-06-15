<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id');
            $table->double('unit_price', 8, 2);
            $table->double('purchase_price', 8, 2);
            $table->double('tax', 8,2)->nullable();
            $table->double('discount', 8,2)->nullable();
            $table->enum('discount_type', ['flat', 'percent'])->nullable();
            $table->double('quantity', 8,2)->nullable();
            $table->double('shipping_cost', 8,2)->nullable();
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_prices');
    }
};
