<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompanyTypeIdToCompanyProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_products', function (Blueprint $table) {
            $table->dropColumn('brand_type');
            $table->tinyInteger('approve')->after('brand_id')->default(0);
            /**
                approve ==  0 : type not selected,
                approve ==  1 : type pending,
                approve ==  2 : type approved,
                approve == -1 : type rejected,
            */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_products', function (Blueprint $table) {
            //
        });
    }
}
