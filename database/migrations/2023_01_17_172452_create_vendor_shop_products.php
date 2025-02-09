<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorShopProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_shop_products', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');

            $table->bigInteger('vendor_id')->unsigned();
            $table->foreign('vendor_id', 'vendor_id_fk')->references('id')->on('vendors');

            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->foreign('category_id', 'cat_id_fk')->references('id')->on('categories');

            $table->bigInteger('brand_id')->unsigned()->nullable();
            $table->foreign('brand_id', 'brand_id_fk')->references('id')->on('brands');

            $table->boolean('is_approved')->default(0);

            $table->string('image');

            $table->string('mobile_img');

            $table->string('pdf')->nullable();

            $table->string('sku_code')->nullable();

            $table->string('video')->nullable();

            $table->double('old_price', 8, 2)->default(0);

            $table->double('new_price', 8, 2)->default(0);

            $table->double('qty', 8, 2)->default(0);

            $table->bigInteger('quantity_type_id')->unsigned()->nullable();
            $table->foreign('quantity_type_id')->references('id')->on('quantity_types');

            $table->boolean('sold_by_souqkahrba')->default(0);

            $table->boolean('featured')->default(0);

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
        Schema::dropIfExists('vendor_shop_products');
    }
}
