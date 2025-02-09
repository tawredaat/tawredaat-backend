<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('company_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['company_id', 'locale']);
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->string('name')->nullable();;
            $table->string('title')->nullable();;
            $table->string('address')->nullable();;
            $table->string('alt')->nullable();;
            $table->mediumtext('description')->nullable();;
            $table->mediumtext('description_meta')->nullable();;
            $table->mediumtext('keywords_meta')->nullable();;
            $table->mediumtext('keywords')->nullable();;
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
        Schema::dropIfExists('company_translations');
    }
}
