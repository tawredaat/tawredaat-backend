<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id') ->on('companies')->onDelete('cascade');
              $table->unsignedBigInteger('brand_id');
            $table->foreign('brand_id')->references('id') ->on('brands')->onDelete('cascade');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id') ->on('products')->onDelete('cascade');
            $table->double('price', 8, 2)->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
              $table->foreign('unit_id')->references('id') ->on('units')->onDelete('cascade');
            $table->double('qty', 8, 2)->nullable();
            $table->double('discount', 4, 2)->nullable();
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
        Schema::dropIfExists('company_products');
    }
}
