<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FaqTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faq_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('f_a_q_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['f_a_q_id', 'locale']);
            $table->foreign('f_a_q_id')->references('id')->on('faqs')->onDelete('cascade');
            $table->longText('content');
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
        //
    }
}