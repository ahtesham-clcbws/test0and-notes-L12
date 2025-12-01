<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorporateEnquiryRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corporate_enquiry_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('corporate_enquiry_id');
            $table->text('message')->nullable();
            $table->enum('type', ['approve','reject','reply'])->default('reply');
            $table->foreignId('user_id');
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
        Schema::dropIfExists('corporate_enquiry_replies');
    }
}
