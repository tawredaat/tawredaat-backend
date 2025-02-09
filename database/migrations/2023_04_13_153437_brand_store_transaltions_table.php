<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BrandStoreTransaltionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_store_banner_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('brand_store_banner_id')->unsigned();
            $table->string('image');
            $table->string('locale')->index();
            $table->unique(['brand_store_banner_id', 'locale'], 'fk_brand_store_banner_unique');
            $table->foreign('brand_store_banner_id', 'fk_brand_store_banner_trans')->references('id')->on('brand_store_banners')->onDelete('cascade');
            $table->string('alt');
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
