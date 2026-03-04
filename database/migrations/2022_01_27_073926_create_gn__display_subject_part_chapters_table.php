<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGnDisplaySubjectPartChaptersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gn__display_subject_part_chapters', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('subject_id');
            $table->bigInteger('subject_part_id');
            $table->string('chapter_id');
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
        Schema::dropIfExists('gn__display_subject_part_chapters');
    }
}
