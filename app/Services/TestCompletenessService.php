<?php

namespace App\Services;

use App\Models\TestModal;
use App\Models\TestSections;
use App\Models\TestQuestions;

class TestCompletenessService
{
    /**
     * Check if a test is fully complete
     * @param TestModal $test
     * @return bool
     */
    public static function isComplete(TestModal $test): bool
    {
        $sections = TestSections::where('test_id', $test->id)->get();

        // 1. Check if the number of sections matches the test setting
        if ($sections->count() != $test->sections) {
            return false;
        }

        // 2. Check if the sum of section questions matches test total_questions
        $totalQuestionsFromSections = $sections->sum('number_of_questions');
        if ($totalQuestionsFromSections != $test->total_questions) {
            return false;
        }

        // 3. Check each section for completeness
        foreach ($sections as $section) {
            // Must have subject and subject_part set
            if (empty($section->subject) || empty($section->subject_part)) {
                return false;
            }

            // Must have exactly the required number of questions assigned
            $assignedQuestionsCount = TestQuestions::where('section_id', $section->id)->count();
            if ($assignedQuestionsCount != $section->number_of_questions) {
                return false;
            }
        }

        return true;
    }

    /**
     * Unpublish the test if it is incomplete
     * @param TestModal $test
     * @return void
     */
    public static function checkAndUnpublish(TestModal $test)
    {
        // Only check if it's currently published
        if ($test->published == 1) {
            if (!self::isComplete($test)) {
                $test->published = 0;
                $test->saveQuietly(); // Use saveQuietly to prevent triggering observers again
            }
        }
    }
}
