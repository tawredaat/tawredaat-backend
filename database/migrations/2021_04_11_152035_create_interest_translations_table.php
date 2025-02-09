<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterestTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interest_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('interest_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['interest_id', 'locale']);
            $table->foreign('interest_id')->references('id')->on('interests')->onDelete('cascade');
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
        Schema::dropIfExists('interest_translations');
    }
}
