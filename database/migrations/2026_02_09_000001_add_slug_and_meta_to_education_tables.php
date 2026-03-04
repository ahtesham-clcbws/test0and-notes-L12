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
        Schema::table('education_type', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('name');
        });

        Schema::table('classes_groups_exams', function (Blueprint $table) {
            $table->string('image')->nullable()->after('name');
            $table->text('summary')->nullable()->after('image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('education_type', function (Blueprint $table) {
            $table->dropColumn('slug');
        });

        Schema::table('classes_groups_exams', function (Blueprint $table) {
            $table->dropColumn(['image', 'summary']);
        });
    }
};
