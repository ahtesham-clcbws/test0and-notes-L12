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
        Schema::table('study_material', function (Blueprint $table) {
            $table->index(['is_featured', 'education_type', 'category'], 'sm_featured_edu_cat_index');
        });

        Schema::table('gn__package_plans', function (Blueprint $table) {
            $table->index(['is_featured', 'education_type', 'expire_date'], 'gpp_featured_edu_expire_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('study_material', function (Blueprint $table) {
            $table->dropIndex('sm_featured_edu_cat_index');
        });

        Schema::table('gn__package_plans', function (Blueprint $table) {
            $table->dropIndex('gpp_featured_edu_expire_index');
        });
    }
};
