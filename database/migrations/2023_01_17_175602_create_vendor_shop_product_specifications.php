<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorShopProductSpecifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_shop_product_specifications', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('vendor_shop_product_id')->unsigned();

            $table->foreign('vendor_shop_product_id',
                'vendor_product_spec_fk')->references('id')
                ->on('vendor_shop_products')->onDelete('cascade');

            $table->bigInteger('specification_id')->unsigned();

            $table->foreign('specification_id')->references('id')
                ->on('specifications')->onDelete('cascade');

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
        Schema::dropIfExists('vendor_shop_product_specifications');
    }
}
