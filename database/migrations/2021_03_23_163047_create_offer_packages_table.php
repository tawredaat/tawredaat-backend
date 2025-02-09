<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_packages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('shop_product_id')->unsigned();
            $table->foreign('shop_product_id')->references('id')->on('shop_products')->onDelete('cascade');
            $table->double('shop_product_qty', 8, 2)->default(0);
            $table->bigInteger('quantity_type_id')->unsigned()->nullable();
            $table->foreign('quantity_type_id')->references('id')->on('quantity_types');
            $table->string('price')->nullable();
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
        Schema::dropIfExists('offer_packages');
    }
}
