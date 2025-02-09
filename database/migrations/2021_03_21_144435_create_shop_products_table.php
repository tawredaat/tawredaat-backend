<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->bigInteger('brand_id')->unsigned()->nullable();
            $table->string('image');
            $table->string('mobileimg');
            $table->string('pdf')->nullable();
            $table->string('sku_code')->nullable();
            $table->string('video')->nullable();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->double('old_price', 8, 2)->default(0);
            $table->double('new_price', 8, 2)->default(0);
            $table->double('qty', 8, 2)->default(0);
            $table->bigInteger('quantity_type_id')->unsigned()->nullable();
            $table->foreign('quantity_type_id')->references('id')->on('quantity_types');
            $table->boolean('soled_by_souqkahrba')->default(0);
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
        Schema::dropIfExists('shop_products');
    }
}
