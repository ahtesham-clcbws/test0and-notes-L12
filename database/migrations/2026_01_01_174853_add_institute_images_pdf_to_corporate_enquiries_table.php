<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('corporate_enquiries', function (Blueprint $table) {
            $table->string('institute_images_pdf')->nullable()->after('photoUrl');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('corporate_enquiries', function (Blueprint $table) {
            $table->dropColumn('institute_images_pdf');
        });
    }
};
