<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdBannerTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_banner_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ad_banner_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['ad_banner_id', 'locale']);
            $table->foreign('ad_banner_id')->references('id')->on('ad_banners')->onDelete('cascade');
            $table->string('firstImage')->nullable();
            $table->string('firstImageAlt')->nullable();
            $table->string('secondImage')->nullable();
            $table->string('secondImageAlt')->nullable();
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
        Schema::dropIfExists('ad_banner_translations');
    }
}
