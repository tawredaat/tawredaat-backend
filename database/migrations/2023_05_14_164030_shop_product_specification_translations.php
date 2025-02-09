<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ShopProductSpecificationTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_product_specification_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('shop_product_specification_id')->unsigned();
            $table->foreign('shop_product_specification_id', 'shop_prod_spec_FK')->references('id')->on('shop_product_specifications')->onDelete('cascade');
            $table->string('value')->nullable();
            $table->string('locale')->index();
            $table->unique(['shop_product_specification_id', 'locale'], 'unique_shop_product_spec_trans_value');
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
        //
    }
}
