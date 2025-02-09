<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLogoToSettingTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('logo');
            $table->dropColumn('site_logo');
            $table->dropColumn('footer_logo');
        });

        Schema::table('setting_translations', function (Blueprint $table) {
            $table->string('logo')->nullable();
            $table->string('site_logo')->nullable();
            $table->string('footer_logo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
