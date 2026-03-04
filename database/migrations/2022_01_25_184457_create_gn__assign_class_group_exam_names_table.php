<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGnAssignClassGroupExamNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gn__assign_class_group_exam_names', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('education_type_id');
            $table->bigInteger('classes_group_exams_id');
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
        Schema::dropIfExists('gn__assign_class_group_exam_names');
    }
}
