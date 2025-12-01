<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGnDisplayClassGroupExamNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gn__display_class_group_exam_names', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('education_type_id');
            $table->string('class_group_exam_name')->length(400);
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
        Schema::dropIfExists('gn__display_class_group_exam_names');
    }
}
