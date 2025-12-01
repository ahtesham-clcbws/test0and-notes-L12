<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGnPackagePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gn__package_plans', function (Blueprint $table) {
            $table->id();
            $table->string('plan_name');
            $table->bigInteger('video_id')->nullable();
            $table->bigInteger('study_material_id')->nullable();
            $table->bigInteger('book_id')->nullable();
            $table->tinyInteger('package_type')->nullable();
            $table->bigInteger('institute_id')->nullable();

            $table->integer('duration');
            $table->integer('free_duration');
            $table->integer('actual_fees');
            $table->integer('discount');
            $table->integer('final_fees');
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('gn__package_plans');
    }
}
