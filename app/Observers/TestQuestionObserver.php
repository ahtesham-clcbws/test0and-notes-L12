<?php

namespace App\Observers;

use App\Models\TestQuestions;
use App\Models\TestModal;
use App\Services\TestCompletenessService;

class TestQuestionObserver
{
    /**
     * Handle the TestQuestions "saved" event.
     *
     * @param  \App\Models\TestQuestions  $question
     * @return void
     */
    public function saved(TestQuestions $question)
    {
        $test = TestModal::find($question->test_id);
        if ($test) {
            TestCompletenessService::checkAndUnpublish($test);
        }
    }

    /**
     * Handle the TestQuestions "deleted" event.
     *
     * @param  \App\Models\TestQuestions  $question
     * @return void
     */
    public function deleted(TestQuestions $question)
    {
        $test = TestModal::find($question->test_id);
        if ($test) {
            TestCompletenessService::checkAndUnpublish($test);
        }
    }
}
