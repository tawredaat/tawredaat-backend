<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id') ->on('users')->onDelete('set null');
            $table->bigInteger('company_id')->unsigned()->nullable();
            $table->foreign('company_id')->references('id') ->on('companies')->onDelete('set null');
            $table->float('subtotal',10,2);
            $table->float('total',10,2);
            $table->float('discount',10,2);
            $table->bigInteger('payment_id')->unsigned()->nullable();
            $table->foreign('payment_id')->references('id') ->on('payments')->onDelete('set null');
            $table->bigInteger('order_status_id')->nullable()->unsigned();
            $table->foreign('order_status_id')->references('id') ->on('order_statuses')->onDelete('set null');
            $table->text('address');
            $table->string('promocode');
            $table->text('comment')->nullable();
            $table->boolean('cancelled')->default(0);
            $table->bigInteger('cancelled_by')->unsigned()->nullable();
            $table->foreign('cancelled_by')->references('id')->on('admins')->onDelete('set null');
            $table->enum('order_from',['Mobile','Web'])->default('Mobile');
            $table->string('deleted_promocode')->nullable()->default(null);
            $table->timestampTz('cancelled_at')->nullable();
            $table->double('differential_price')->default(0);
            $table->string('transaction_id')->nullable();
            $table->double('delivery_charge')->default(0.0);
            $table->integer('remaining')->default(0);
            $table->float('purchaseAmount',10,2)->nullable();
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
        Schema::dropIfExists('orders');
    }
}
