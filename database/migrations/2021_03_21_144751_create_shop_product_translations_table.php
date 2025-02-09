<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopProductTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_product_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('shop_product_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['shop_product_id', 'locale']);
            $table->foreign('shop_product_id')->references('id')->on('shop_products')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('title')->nullable();
            $table->string('alt')->nullable();
            $table->longtext('description')->nullable();
            $table->longtext('description_meta')->nullable();
            $table->longtext('keywords')->nullable();
            $table->longtext('keywords_meta')->nullable();
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
        Schema::dropIfExists('shop_product_translations');
    }
}
