<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $educationTypes = \Illuminate\Support\Facades\DB::table('education_type')->get();

        foreach ($educationTypes as $type) {
            \Illuminate\Support\Facades\DB::table('education_type')
                ->where('id', $type->id)
                ->update(['slug' => \Illuminate\Support\Str::slug($type->name)]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Illuminate\Support\Facades\DB::table('education_type')->update(['slug' => null]);
    }
};
