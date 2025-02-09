<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompanyProductIdToGeneralRfqProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('general_rfq_products', function (Blueprint $table) {
            $table->unsignedBigInteger('company_product_id');
            $table->foreign('company_product_id')->references('id')->on('company_products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('general_rfq_products', function (Blueprint $table) {
            $table->dropColumn('company_product_id');
        });
    }
}
