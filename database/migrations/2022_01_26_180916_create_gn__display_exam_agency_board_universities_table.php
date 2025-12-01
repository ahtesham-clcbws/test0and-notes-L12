<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGnDisplayExamAgencyBoardUniversitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gn__display_exam_agency_board_universities', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('education_type_id');
            $table->bigInteger('classes_group_exams_id');
            $table->string('board_id');
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
        Schema::dropIfExists('gn__display_exam_agency_board_universities');
    }
}
