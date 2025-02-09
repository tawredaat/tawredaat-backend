<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandBannerTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_banner_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('brand_banner_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['brand_banner_id', 'locale']);
            $table->foreign('brand_banner_id')->references('id')->on('brand_banners')->onDelete('cascade');
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
        Schema::dropIfExists('brand_banner_translations');
    }
}
