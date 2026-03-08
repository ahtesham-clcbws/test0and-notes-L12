<?php

namespace App\Observers;

use App\Models\TestSections;
use App\Models\TestModal;
use App\Services\TestCompletenessService;

class TestSectionObserver
{
    /**
     * Handle the TestSections "saved" event.
     *
     * @param  \App\Models\TestSections  $section
     * @return void
     */
    public function saved(TestSections $section)
    {
        $test = TestModal::find($section->test_id);
        if ($test) {
            TestCompletenessService::checkAndUnpublish($test);
        }
    }

    /**
     * Handle the TestSections "deleted" event.
     *
     * @param  \App\Models\TestSections  $section
     * @return void
     */
    public function deleted(TestSections $section)
    {
        $test = TestModal::find($section->test_id);
        if ($test) {
            TestCompletenessService::checkAndUnpublish($test);
        }
    }
}
