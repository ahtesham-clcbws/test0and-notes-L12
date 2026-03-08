<?php

namespace App\Observers;

use App\Models\TestModal;
use App\Services\TestCompletenessService;

class TestObserver
{
    /**
     * Handle the TestModal "saved" event.
     *
     * @param  \App\Models\TestModal  $test
     * @return void
     */
    public function saved(TestModal $test)
    {
        TestCompletenessService::checkAndUnpublish($test);
    }
}
