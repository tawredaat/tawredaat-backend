<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColsToShopProductTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shop_product_translations', function (Blueprint $table) {
            if (!Schema::hasColumn('shop_product_translations', 'note')) {
                $table->string('note')->nullable();
            }
            if (!Schema::hasColumn('shop_product_translations', 'seller')) {
                $table->string('seller')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_product_translations', function (Blueprint $table) {
            if (Schema::hasColumn('shop_product_translations', 'note')) {
                $table->dropColumn('note');
            }
            if (Schema::hasColumn('shop_product_translations', 'seller')) {
                $table->dropColumn('seller');
            }
        });
    }
}
