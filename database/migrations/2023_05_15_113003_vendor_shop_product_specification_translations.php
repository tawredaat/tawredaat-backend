<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VendorShopProductSpecificationTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_shop_product_specification_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('vendor_shop_product_specification_id')->unsigned();
            $table->foreign('vendor_shop_product_specification_id', 'vendor_shop_prod_spec_FK')
                ->references('id')->on('vendor_shop_product_specifications')->onDelete('cascade');
            $table->string('value')->nullable();
            $table->string('locale')->index();
            $table->unique(['vendor_shop_product_specification_id', 'locale'], 'unique_vendor_shop_product_spec_trans_value');
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
