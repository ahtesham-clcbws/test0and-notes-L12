<?php

namespace App\Livewire\Student\Tests;

use App\Models\TestAttempt;
use App\Models\TestAttemptAnswer;
use App\Models\TestModal;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.student-exam-mary')]
class TestReview extends Component
{
    public int $testId;

    public int $studentId;

    public ?int $attemptId = null;

    public ?TestModal $test = null;

    public ?int $selectedQuestionId = null;

    public bool $showSolutionModal = false;

    public string $mode = 'review';

    public int $endTimestamp = 0;

    public ?string $selectedAnswer = null;

    public int $attemptedCount = 0;

    public int $unattemptedCount = 0;

    public int $reviewCount = 0;

    public int $visitedCount = 0;

    public int $total_question = 0;

    public function viewSolution(int|string $questionId): void
    {
        $this->selectedQuestionId = (int) $questionId;

        $attempt = TestAttempt::find($this->attemptId);

        if ($attempt) {
            $resp = TestAttemptAnswer::where('test_attempt_id', $attempt->id)
                ->where('question_id', $this->selectedQuestionId)
                ->first();

            // Secure Review Mode: only allow viewing if marked for review
            if (! $resp || ! $resp->is_marked_for_review) {
                return;
            }

            $this->selectedAnswer = $resp->answer;
            $this->showSolutionModal = true;
        } else {
            $this->selectedAnswer = null;
        }
    }

    public function selectAnswerOption(string $option): void
    {
        $this->selectedAnswer = $option;
    }

    public function saveReviewAnswer(): void
    {
        $attempt = TestAttempt::find($this->attemptId);

        if (! $attempt || $attempt->student_id !== Auth::id()) {
            return;
        }

        $resp = TestAttemptAnswer::where('test_attempt_id', $attempt->id)
            ->where('question_id', $this->selectedQuestionId)
            ->first();

        if ($resp && $resp->is_marked_for_review) {
            $resp->update([
                'answer' => $this->selectedAnswer,
                'is_marked_for_review' => false,
            ]);

            $this->calculateCounts($attempt);

            session()->flash('message', 'Answer updated successfully!');
            $this->showSolutionModal = false;
        }
    }

    public function submitTest()
    {
        $attempt = TestAttempt::find($this->attemptId);

        if ($attempt) {
            $attempt->update([
                'status' => 'completed',
                'submitted_at' => now(),
            ]);
        }

        $payload = \Illuminate\Support\Facades\Crypt::encrypt([
            'student_id' => $this->studentId,
            'test_id' => $this->testId,
            'mode' => 'result',
        ]);

        return redirect()->route('student.show-result', ['payload' => $payload]);
    }

    public function mount(string $payload)
    {
        try {
            $decrypted = \Illuminate\Support\Facades\Crypt::decrypt($payload);
            $this->studentId = (int) $decrypted['student_id'];
            $this->testId = (int) $decrypted['test_id'];
            $this->mode = $decrypted['mode'] ?? 'review';
        } catch (\Exception $e) {
            return redirect()->route('student.dashboard');
        }

        $this->test = TestModal::find($this->testId);

        if (! $this->test || Auth::id() != $this->studentId) {
            return redirect()->route('student.dashboard');
        }

        $attempt = TestAttempt::where('student_id', $this->studentId)
            ->where('test_id', $this->testId)
            ->first();

        if ($attempt && $attempt->status === 'completed') {
            // Already completed, redirect to show-result!
            $resPayload = \Illuminate\Support\Facades\Crypt::encrypt([
                'student_id' => $this->studentId,
                'test_id' => $this->testId,
                'mode' => 'result',
            ]);

            return redirect()->route('student.show-result', ['payload' => $resPayload]);
        }

        if ($attempt && $attempt->status === 'running') {
            $totalDuration = $this->test->time_to_complete;
            if (! $totalDuration) {
                $section_time = $this->test->testSections()
                    ->select('number_of_questions', 'duration')
                    ->get()
                    ->toArray();

                $timeArray = [];
                foreach ($section_time as $section) {
                    $timeArray[] = ($section['number_of_questions'] ?? 0) * ($section['duration'] ?? 0);
                }
                $totalDuration = array_sum($timeArray);
            }

            if (! $totalDuration || $totalDuration <= 0) {
                $totalDuration = 60;
            }

            $expiryTime = $attempt->created_at->timestamp + ($totalDuration * 60);
            if (now()->timestamp >= $expiryTime) {
                $attempt->update([
                    'status' => 'completed',
                    'submitted_at' => now(),
                ]);

                $resPayload = \Illuminate\Support\Facades\Crypt::encrypt([
                    'student_id' => $this->studentId,
                    'test_id' => $this->testId,
                    'mode' => 'result',
                ]);

                return redirect()->route('student.show-result', ['payload' => $resPayload]);
            } else {
                $this->endTimestamp = $expiryTime * 1000;
            }
        }

        $this->calculateCounts($attempt);
    }

    protected function calculateCounts(?TestAttempt $attempt): void
    {
        if (! $attempt) {
            return;
        }

        $this->attemptId = $attempt->id;

        $test_response = TestAttemptAnswer::where('test_attempt_id', $this->attemptId)
            ->get()
            ->keyBy('question_id');

        $allQuestions = $this->test->getQuestions()->distinct()->get();
        $this->total_question = $allQuestions->count();

        $this->attemptedCount = 0;
        $this->unattemptedCount = 0;
        $this->reviewCount = 0;
        $this->visitedCount = 0;

        foreach ($allQuestions as $question) {
            $response = $test_response->get($question->id);

            if ($response && ($response->answer !== null && $response->answer !== '')) {
                $this->attemptedCount++;
            } else {
                $this->unattemptedCount++;
            }

            if ($response) {
                if ($response->is_marked_for_review) {
                    $this->reviewCount++;
                }
                if ($response->is_visited) {
                    $this->visitedCount++;
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.student.tests.test-review');
    }
}
