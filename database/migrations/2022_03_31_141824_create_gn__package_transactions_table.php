<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGnPackageTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gn__package_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student_id');
            $table->integer('plan_id');
            $table->string('plan_name');
            $table->string('plan_amount');
            $table->tinyInteger('payment_type')->default(0)->comment('0:RazorPay,1:Cash,2:NEFT');
            $table->integer('plan_duration');
            $table->integer('plan_start_date')->nullable();
            $table->integer('plan_end_date')->nullable();
            $table->string('razorpay_payment_id')->nullable();
            $table->string('razorpay_order_id')->nullable();
            $table->string('razorpay_signature')->nullable();
            $table->string('transaction_id')->nullable();
            $table->integer('transaction_date')->nullable();
            $table->tinyInteger('plan_in_queue')->default(0)->comment('0:No,1:Yes');
            $table->tinyInteger('plan_status')->default(3)->comment('0:Pending,1:Active,2:Exipred,3:Inactive');
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
        Schema::dropIfExists('gn__package_transactions');
    }
}
