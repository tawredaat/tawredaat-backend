<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertisingTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertising_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('advertising_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['advertising_id', 'locale']);
            $table->foreign('advertising_id')->references('id')->on('advertisings')->onDelete('cascade');
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
        Schema::dropIfExists('advertising_translations');
    }
}
