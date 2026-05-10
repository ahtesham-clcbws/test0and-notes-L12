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
        Schema::table('gn__student_test_attempts', function (Blueprint $table) {
            $table->boolean('is_in_review')->default(0)->after('status');
            $table->timestamp('submitted_at')->nullable()->after('is_in_review');
        });

        Schema::table('gn__test__responses', function (Blueprint $table) {
            $table->boolean('is_visited')->default(0)->after('answer');
            $table->boolean('is_marked')->default(0)->after('is_visited');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gn__student_test_attempts', function (Blueprint $table) {
            $table->dropColumn(['is_in_review', 'submitted_at']);
        });

        Schema::table('gn__test__responses', function (Blueprint $table) {
            $table->dropColumn(['is_visited', 'is_marked']);
        });
    }
};
