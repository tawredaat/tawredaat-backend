<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttributesToAdBannerTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ad_banner_translations', function (Blueprint $table) {
            $table->string('mobileFirstImage')->nullable();
            $table->string('mobileSecondImage')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ad_banner_translations', function (Blueprint $table) {
            //
        });
    }
}
