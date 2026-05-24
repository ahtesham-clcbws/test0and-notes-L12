<?php

namespace App\Livewire\Student\Tests;

use App\Models\TestAttempt;
use App\Models\TestAttemptAnswer;
use App\Models\TestModal;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.student-exam-mary')]
class ShowResult extends Component
{
    public int $testId;

    public int $studentId;

    public ?int $attemptId = null;

    public ?TestModal $test = null;

    public int $total_question = 0;

    public int|float $total_marks = 0;

    public int $correct_answer = 0;

    public int $incorrect_answer = 0;

    public int $not_attempted = 0;

    public int|float $negative_marks = 0;

    public int|float $out_of_marks = 0;

    public int|float $final_marks = 0;

    public ?int $selectedQuestionId = null;

    public bool $showSolutionModal = false;

    public string $mode = 'result';

    public ?string $selectedAnswer = null;

    public int $attemptedCount = 0;

    public int $unattemptedCount = 0;

    public int $reviewCount = 0;

    public int $visitedCount = 0;

    public function viewSolution(int|string $questionId): void
    {
        $this->selectedQuestionId = (int) $questionId;

        $attempt = TestAttempt::find($this->attemptId);

        if ($attempt) {
            $resp = TestAttemptAnswer::where('test_attempt_id', $attempt->id)
                ->where('question_id', $this->selectedQuestionId)
                ->first();

            $this->selectedAnswer = $resp ? $resp->answer : null;
            $this->showSolutionModal = true;
        } else {
            $this->selectedAnswer = null;
        }
    }

    public function mount(string $payload)
    {
        try {
            $decrypted = \Illuminate\Support\Facades\Crypt::decrypt($payload);
            $this->studentId = (int) $decrypted['student_id'];
            $this->testId = (int) $decrypted['test_id'];
            $this->mode = $decrypted['mode'] ?? 'result';
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

        // Safe-guard: if attempt is still running/active, redirect to dedicated review screen!
        if ($attempt && $attempt->status === 'running') {
            $revPayload = \Illuminate\Support\Facades\Crypt::encrypt([
                'student_id' => $this->studentId,
                'test_id' => $this->testId,
                'mode' => 'review',
            ]);

            return redirect()->route('student.test-review', ['payload' => $revPayload]);
        }

        if ($this->test->show_result != 1) {
            session()->flash('error', 'Result will be displayed soon...');

            return redirect()->back();
        }

        $this->calculateResult($attempt);
    }

    protected function calculateResult(?TestAttempt $attempt): void
    {
        if (! $attempt) {
            $this->not_attempted = $this->test->getQuestions()->distinct()->count();

            return;
        }

        $this->attemptId = $attempt->id;

        $test_response = TestAttemptAnswer::where('test_attempt_id', $this->attemptId)
            ->get()
            ->keyBy('question_id');

        $allQuestions = $this->test->getQuestions()->distinct()->get();
        $this->total_question = $allQuestions->count();

        $this->correct_answer = 0;
        $this->incorrect_answer = 0;
        $this->not_attempted = 0;
        $this->attemptedCount = 0;
        $this->unattemptedCount = 0;
        $this->reviewCount = 0;
        $this->visitedCount = 0;

        foreach ($allQuestions as $question) {
            $response = $test_response->get($question->id);

            if ($response && ($response->answer !== null && $response->answer !== '')) {
                if ($question->mcq_answer === $response->answer) {
                    $this->correct_answer++;
                } else {
                    $this->incorrect_answer++;
                }
            } else {
                $this->not_attempted++;
            }

            if ($response) {
                if ($response->answer !== null && $response->answer !== '') {
                    $this->attemptedCount++;
                }
                if ($response->is_marked_for_review) {
                    $this->reviewCount++;
                }
                if ($response->is_visited) {
                    $this->visitedCount++;
                }
            }
        }

        $this->unattemptedCount = $this->total_question - $this->attemptedCount;

        $marksPerQ = $this->test->gn_marks_per_questions ?? 1;
        $negMarksPerQ = ($this->test->negative_marks ?? 0) * $marksPerQ;

        $this->total_marks = $this->correct_answer * $marksPerQ;
        $this->negative_marks = $this->incorrect_answer * $negMarksPerQ;

        $this->final_marks = $this->total_marks - $this->negative_marks;
        $this->out_of_marks = $this->total_question * $marksPerQ;
    }

    public function render()
    {
        return view('livewire.student.tests.show-result');
    }
}
