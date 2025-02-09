<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryBannerTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_banner_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('category_banner_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['category_banner_id', 'locale']);
            $table->foreign('category_banner_id')->references('id')->on('category_banners')->onDelete('cascade');
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
        Schema::dropIfExists('categories_banner_translations');
    }
}