<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAreaOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('area_operations', function($table)
        {
            $table->dropColumn('name_ar');
            $table->dropColumn('name_en');
            $table->bigInteger('area_id')->unsigned();
            $table->foreign('area_id')->references('id') ->on('areas')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->dropColumn('area_id');
    }
}
