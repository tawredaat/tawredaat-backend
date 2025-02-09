<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttributesToBrandTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brand_translations', function (Blueprint $table) {
            $table->string('products_title')->nullable();
            $table->text('products_description')->nullable();
            $table->text('products_keywords')->nullable();
            $table->string('distributors_title')->nullable();
            $table->text('distributors_description')->nullable();
            $table->text('distributors_keywords')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brand_translations', function (Blueprint $table) {
            //
        });
    }
}
