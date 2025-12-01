<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Unique;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique();
            $table->string('photo_url')->nullable();
            $table->string('series_id')->nullable();
            $table->text('about')->nullable();
            $table->string('institute_code')->nullable();
            $table->foreignId('city');
            $table->foreignId('state');
            $table->mediumInteger('country');
            $table->boolean('allowed_to_upload')->default(0);
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
        Schema::dropIfExists('user_details');
    }
}
