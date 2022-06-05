<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFawryTransactionsTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fawry_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('referenceNumber');
            $table->string('merchantRefNumber');
            $table->string('orderAmount');
            $table->string('paymentAmount');
            $table->string('fawryFees');
            $table->string('paymentMethod');
            $table->string('paymentTime')->nullable();
            $table->string('customerName');
            $table->string('customerMobile');
            $table->string('customerMail');
            $table->string('taxes');
            $table->string('statusCode');
            $table->string('statusDescription');
            $table->string('basketPayment');

            $table->unsignedBigInteger('fawry_order_status_id')->nullable();
            $table->foreign("fawry_order_status_id")->references("id")->on("fawry_order_status")->onDelete("cascade");

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");

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
        Schema::dropIfExists('fawry_transactions');
    }
}
