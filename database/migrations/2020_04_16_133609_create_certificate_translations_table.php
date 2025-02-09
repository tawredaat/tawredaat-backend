<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificateTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificate_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('certificate_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['certificate_id', 'locale']);
            $table->foreign('certificate_id')->references('id')->on('certificates')->onDelete('cascade');
            $table->string('CertiName')->nullable();
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
        Schema::dropIfExists('certificate_translations');
    }
}
