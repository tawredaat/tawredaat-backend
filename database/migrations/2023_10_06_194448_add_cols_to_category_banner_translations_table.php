<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColsToCategoryBannerTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category_banner_translations', function (Blueprint $table) {
            $table->string('image');
            $table->string('mobile_image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('category_banner_translations', function (Blueprint $table) {
            $table->string('image');
            $table->string('mobile_image');
        });
    }
}
