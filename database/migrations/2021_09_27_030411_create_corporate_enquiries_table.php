<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorporateEnquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corporate_enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('institute_name')->nullable();
            $table->text('type_of_institution')->nullable();
            $table->text('interested_for')->nullable();
            $table->integer('established_year')->nullable();
            $table->string('email')->nullable();
            $table->bigInteger('mobile')->nullable();
            $table->string('address')->nullable();
            $table->foreignId('city_id');
            $table->foreignId('state_id');
            $table->bigInteger('pincode')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['new', 'approved', 'rejected'])->default('new');
            $table->string('branch_code')->unique()->nullable();
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('corporate_enquiries');
    }
}
