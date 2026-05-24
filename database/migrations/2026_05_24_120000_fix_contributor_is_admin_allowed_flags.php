<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Contributors (direct and institute staff) were incorrectly flagged with
     * isAdminAllowed = 1, which sent them to the administrator panel. Only
     * superadmin accounts should keep that flag.
     */
    public function up(): void
    {
        DB::table('users')
            ->where('is_staff', 1)
            ->where('is_franchise', 0)
            ->where('isAdminAllowed', 1)
            ->where(function ($query) {
                $query->whereNull('roles')
                    ->orWhere('roles', 'not like', '%superadmin%');
            })
            ->whereNull('deleted_at')
            ->update([
                'isAdminAllowed' => 0,
                'updated_at' => now(),
            ]);
    }

    /**
     * Cannot safely restore previous isAdminAllowed values.
     */
    public function down(): void
    {
        // Irreversible data correction.
    }
};
