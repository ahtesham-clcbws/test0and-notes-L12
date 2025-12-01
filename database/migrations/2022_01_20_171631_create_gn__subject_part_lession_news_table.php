<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGnSubjectPartLessionNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gn__subject_part_lession_news', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('subject_id');
            $table->bigInteger('subject_part_id');
            $table->bigInteger('subject_chapter_id');
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
        Schema::dropIfExists('gn__subject_part_lession_news');
    }
}
