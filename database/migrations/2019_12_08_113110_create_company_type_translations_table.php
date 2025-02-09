<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyTypeTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_type_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('company_type_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['company_type_id', 'locale']);
            $table->foreign('company_type_id')->references('id')->on('company_types')->onDelete('cascade');
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
        Schema::dropIfExists('company_type_translations');
    }
}
