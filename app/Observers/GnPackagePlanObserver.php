<?php

namespace App\Observers;

use App\Models\Gn_PackagePlan;
use Illuminate\Support\Facades\Cache;

class GnPackagePlanObserver
{
    /**
     * Handle the Gn_PackagePlan "created" event.
     */
    public function created(Gn_PackagePlan $gnPackagePlan): void
    {
        $this->clearHomeCache();
    }

    /**
     * Handle the Gn_PackagePlan "updated" event.
     */
    public function updated(Gn_PackagePlan $gnPackagePlan): void
    {
        $this->clearHomeCache();
    }

    /**
     * Handle the Gn_PackagePlan "deleted" event.
     */
    public function deleted(Gn_PackagePlan $gnPackagePlan): void
    {
        $this->clearHomeCache();
    }

    /**
     * Handle the Gn_PackagePlan "restored" event.
     */
    public function restored(Gn_PackagePlan $gnPackagePlan): void
    {
        $this->clearHomeCache();
    }

    /**
     * Handle the Gn_PackagePlan "force deleted" event.
     */
    public function forceDeleted(Gn_PackagePlan $gnPackagePlan): void
    {
        $this->clearHomeCache();
    }

    private function clearHomeCache()
    {
        Cache::forget('home_package_test_notes');
        Cache::forget('home_package_test_notes_2');
        Cache::forget('home_package_list');
        Cache::forget('home_package_institute');
    }
}
