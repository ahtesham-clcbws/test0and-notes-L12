<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->addIndexIfNotExists('user_details', ['education_type', 'class'], 'ud_edu_class_index');
        $this->addIndexIfNotExists('test', ['education_type_id', 'education_type_child_id', 'published'], 'test_edu_child_pub_index');
        $this->addIndexIfNotExists('study_material', ['education_type', 'class', 'category'], 'sm_edu_class_cat_index');
        $this->addIndexIfNotExists('gn__package_plans', ['education_type', 'class', 'status'], 'gpp_edu_class_status_index');
        $this->addIndexIfNotExists('gn__package_plan_tests', ['gn_package_plan_id', 'test_id'], 'gppt_plan_test_index');
        $this->addIndexIfNotExists('gn__package_transactions', ['student_id', 'plan_id'], 'gpt_student_plan_index');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->dropIndexIfExists('user_details', 'ud_edu_class_index');
        $this->dropIndexIfExists('test', 'test_edu_child_pub_index');
        $this->dropIndexIfExists('study_material', 'sm_edu_class_cat_index');
        $this->dropIndexIfExists('gn__package_plans', 'gpp_edu_class_status_index');
        $this->dropIndexIfExists('gn__package_plan_tests', 'gppt_plan_test_index');
        $this->dropIndexIfExists('gn__package_transactions', 'gpt_student_plan_index');
    }

    private function addIndexIfNotExists(string $table, array $columns, string $indexName): void
    {
        try {
            $indexes = DB::select("SHOW INDEX FROM `$table` WHERE Key_name = ?", [$indexName]);
            if (empty($indexes)) {
                Schema::table($table, function (Blueprint $table) use ($columns, $indexName) {
                    $table->index($columns, $indexName);
                });
            }
        } catch (\Exception $e) {
            // Log or ignore if table doesn't exist to prevent crash
        }
    }

    private function dropIndexIfExists(string $table, string $indexName): void
    {
        try {
            $indexes = DB::select("SHOW INDEX FROM `$table` WHERE Key_name = ?", [$indexName]);
            if (! empty($indexes)) {
                Schema::table($table, function (Blueprint $table) use ($indexName) {
                    $table->dropIndex($indexName);
                });
            }
        } catch (\Exception $e) {
            // Ignore
        }
    }
};
