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
        Schema::table('gn__package_plans', function (Blueprint $table) {
            $table->tinyInteger('is_mobile')->default(0)->after('status');
            $table->string('banner')->nullable()->after('package_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gn__package_plans', function (Blueprint $table) {
            $table->dropColumn(['is_mobile', 'banner']);
        });
    }
};
