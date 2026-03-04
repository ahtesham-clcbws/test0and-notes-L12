<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('course_details', function (Blueprint $table) {
        //     $table->id();
        //     $table->bigInteger('class_group_examp_id');
        //     $table->string('course_full_name')->nullable();
        //     $table->string('course_short_name')->nullable();
        //     $table->string('course_image')->nullable();
        //     $table->longText('description')->nullable();
        //     $table->string('notification_image')->nullable();
        //     $table->string('exam_detail')->nullable();
        //     $table->string('free_study_note')->nullable();
        //     $table->string('previous_papers')->nullable();
        //     $table->string('notification_data')->nullable();
        //     $table->string('registration')->nullable();
        //     $table->string('exam_date')->nullable();
        //     $table->string('exam_mode')->nullable();
        //     $table->integer('vacancies')->nullable();
        //     $table->string('eligibility')->nullable();
        //     $table->string('salary')->nullable();
        //     $table->string('official_site')->nullable();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_details');
    }
}
