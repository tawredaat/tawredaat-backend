<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecificationTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specification_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('specification_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['specification_id', 'locale']);
            $table->foreign('specification_id')->references('id')->on('specifications')->onDelete('cascade');
            $table->string('name');
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
        Schema::dropIfExists('specification_translations');
    }
}
