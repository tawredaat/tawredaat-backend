<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopProductSpecificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_product_specifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('shop_product_id')->unsigned();
            $table->foreign('shop_product_id')->references('id')->on('shop_products')->onDelete('cascade');
            $table->bigInteger('specification_id')->unsigned();
            $table->foreign('specification_id')->references('id')->on('specifications')->onDelete('cascade');
            $table->string('value');
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
        Schema::dropIfExists('shop_product_specifications');
    }
}
