<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellPolicyTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sell_policy_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sell_policy_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['sell_policy_id', 'locale']);
            $table->foreign('sell_policy_id')->references('id')->on('sell_policies')->onDelete('cascade');
            $table->longText('content');
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
        Schema::dropIfExists('sell_policy_translations');
    }
}
