<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGnOtherExamClassDetailModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gn__other_exam_class_detail_models', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('education_type_id');
            $table->bigInteger('classes_group_exams_id');
            $table->bigInteger('agency_board_university_id');
            $table->string('name');
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
        Schema::dropIfExists('gn__other_exam_class_detail_models');
    }
}
