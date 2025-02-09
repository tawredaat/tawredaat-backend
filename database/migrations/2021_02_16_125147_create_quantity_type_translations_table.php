<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuantityTypeTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quantity_type_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('quantity_type_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['quantity_type_id', 'locale']);
            $table->foreign('quantity_type_id')->references('id')->on('quantity_types')->onDelete('cascade');
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
        Schema::dropIfExists('quantity_type_translations');
    }
}
