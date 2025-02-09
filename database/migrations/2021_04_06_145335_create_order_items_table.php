<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('shop_product_id')->unsigned()->nullable();
            $table->foreign('shop_product_id')->references('id')->on('shop_products')->onDelete('set null')->onUpdate('set null');
            $table->bigInteger('company_id')->unsigned()->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null')->onUpdate('set null');
            $table->bigInteger('offer_package_id')->unsigned()->nullable();
            $table->foreign('offer_package_id')->references('id')->on('offer_packages')->onDelete('set null')->onUpdate('set null');
            $table->float('quantity',7,2);
            $table->float('price',7,2);
            $table->float('amount',7,2);
            $table->float('purchaseQuantity',7,2)->nullable();
            $table->boolean('promocode_applied')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
