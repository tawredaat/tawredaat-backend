<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopBannerTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_banner_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('shop_banner_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['shop_banner_id', 'locale']);
            $table->foreign('shop_banner_id')->references('id')->on('shop_banners')->onDelete('cascade');
            $table->string('alt')->nullable();
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
        Schema::dropIfExists('banner_translations');
    }
}
