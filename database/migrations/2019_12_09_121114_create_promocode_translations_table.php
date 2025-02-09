<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromocodeTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promocode_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('promocode_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['promocode_id', 'locale']);
            $table->foreign('promocode_id')->references('id')->on('promocodes')->onDelete('cascade');
            $table->string('name')->nullable();
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
        Schema::dropIfExists('promocode_translations');
    }
}
