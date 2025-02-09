<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('company_name');

            $table->string('responsible_person_name');

            $table->string('responsible_person_mobile_number');

            $table->string('responsible_person_email')->unique();

            $table->string('password');

            $table->string('commercial_license');

            $table->string('tax_number_certificate');

            $table->string('added_value_certificate')->nullable();

            $table->string('contractors_association_certificate')->nullable();

            $table->enum('company_type', ['contractor', 'seller', 'electrician']);

            $table->boolean('is_approved')->default(0);

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
        Schema::dropIfExists('vendors');
    }
}
