<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OnlineTransactionValu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_transaction_valus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('online_transaction_id')->unsigned();
            $table->foreign('online_transaction_id')->references('id')
                ->on('online_transactions');
            $table->string('down_payment')->nullable();
            $table->string('installment_plan')->nullable();
            $table->text('installment_plan_list')->nullable();
            // emi
            $table->string('monthly_installment')->nullable();
            $table->string('purchase_fees')->nullable();
            $table->string('customer_code')->nullable();
            $table->text('receipt_url')->nullable();
            $table->string('purchase_ref_number')->nullable();
            $table->string('product_ref_number')->nullable();
            $table->string('pan')->nullable();
            $table->timestamps();
        });

        /*Receipt Url    Receipt Url
    Product ref number    CL121118123434
    Down Payment    0.0EGP
    Financed Amount    1100EGP
    monthly installment    123EGP
    installment_plan    6
    Purchase Ref Number    106156543122390613*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
