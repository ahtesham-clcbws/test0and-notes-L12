<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGnEducationClassExamAgencyBoardUniversitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gn__education_class_exam_agency_board_universities', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('education_type_id');
            $table->bigInteger('classes_group_exams_id');
            $table->bigInteger('board_agency_exam_id');
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
        Schema::dropIfExists('gn__education_class_exam_agency_board_universities');
    }
}
