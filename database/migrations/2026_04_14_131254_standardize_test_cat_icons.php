<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Standardize icons for core test categories
        DB::table('test_cat')->where('id', 4)->update(['cat_image' => 'student1/images/1.png']);
        DB::table('test_cat')->where('id', 5)->update(['cat_image' => 'student1/images/2.png']);
        DB::table('test_cat')->where('id', 6)->update(['cat_image' => 'student1/images/3.png']);
        DB::table('test_cat')->where('id', 7)->update(['cat_image' => 'student1/images/4.png']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverting to some common defaults or null if needed,
        // though typically we don't revert data changes unless critical.
    }
};
