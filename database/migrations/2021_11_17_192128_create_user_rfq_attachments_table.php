<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRfqAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_rfq_attachments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_rfq_id')->unsigned();
            $table->foreign('user_rfq_id')->references('id')->on('user_rfqs');
            $table->string('attachment');
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
        Schema::dropIfExists('user_rfq_attachments');
    }
}
