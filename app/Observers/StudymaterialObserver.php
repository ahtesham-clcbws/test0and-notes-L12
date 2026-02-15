<?php

namespace App\Observers;

use App\Models\Studymaterial;
use Illuminate\Support\Facades\Cache;

class StudymaterialObserver
{
    /**
     * Handle the Studymaterial "created" event.
     */
    public function created(Studymaterial $studymaterial): void
    {
        $this->clearHomeCache();
    }

    /**
     * Handle the Studymaterial "updated" event.
     */
    public function updated(Studymaterial $studymaterial): void
    {
        $this->clearHomeCache();
    }

    /**
     * Handle the Studymaterial "deleted" event.
     */
    public function deleted(Studymaterial $studymaterial): void
    {
        $this->clearHomeCache();
    }

    /**
     * Handle the Studymaterial "restored" event.
     */
    public function restored(Studymaterial $studymaterial): void
    {
        $this->clearHomeCache();
    }

    /**
     * Handle the Studymaterial "force deleted" event.
     */
    public function forceDeleted(Studymaterial $studymaterial): void
    {
        $this->clearHomeCache();
    }

    private function clearHomeCache()
    {
        Cache::forget('home_study_gov_comp');
        Cache::forget('home_study_gov_comp_2');
        Cache::forget('home_study_gov_comp_3');
        Cache::forget('home_study_gov_comp_4');
        Cache::forget('home_study_gov_comp_5');
        Cache::forget('home_study_affairs');
    }
}
