<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRefundAndReturnsPolicyTranslation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refund_and_returns_policy_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('refund_and_returns_policy_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['refund_and_returns_policy_id', 'locale'],
                'unique_refunds_policy_locale');
            $table->foreign('refund_and_returns_policy_id', 'refund_and_returns_policy_id_fk')->references('id')->on('refund_and_returns_policies')->onDelete('cascade');
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
        Schema::dropIfExists('refund_and_returns_policy_translations');
    }
}
