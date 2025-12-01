<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGnPackagePlanTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gn__package_plan_tests', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("gn_package_plan_id");
            $table->bigInteger("test_id");
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
        Schema::dropIfExists('gn__package_plan_tests');
    }
}
