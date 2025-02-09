<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('logo')->nullable();
            $table->string('cover')->nullable();
            $table->date('date')->nullable();
            $table->string('brochure')->nullable();
            $table->string('price_lists')->nullable();
            $table->string('sales_mobile')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('company_email')->nullable();
            $table->string('pri_contact_phone')->nullable();
            $table->string('pri_contact_email')->nullable();
            $table->string('pri_contact_name')->nullable();
            $table->text('map')->nullable();
            $table->text('facebook')->nullable();
            $table->text('insta')->nullable();
            $table->text('twitter')->nullable();
            $table->text('youtube')->nullable();
            $table->text('linkedin')->nullable();
            $table->string('password')->nullable();
            $table->boolean('gold_sup')->default(1);
            $table->boolean('hidden')->default(1);
            $table->string('featured')->nullable();
            $table->double('rank',8,2)->default(0);
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
        Schema::dropIfExists('companies');
    }
}
