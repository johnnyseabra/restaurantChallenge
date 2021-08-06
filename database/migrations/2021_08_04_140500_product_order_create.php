<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductOrderCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_orders', function (Blueprint $table) {
            
            //Fields
            $table->unsignedBigInteger('product');
            $table->unsignedBigInteger('order');
            $table->unsignedInteger('quantity');
            
            //FK
            $table->foreign('product')->references('id')->on('products');
            $table->foreign('order')->references('id')->on('orders');
            //PK
            $table->primary(['product', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products_orders');
    }
}
