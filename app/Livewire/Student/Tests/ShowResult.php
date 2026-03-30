<?php

namespace App\Livewire\Student\Tests;

use App\Models\Gn_Test_Response;
use App\Models\TestModal;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.student-mary')]
class ShowResult extends Component
{
    public $testId;

    public $studentId;

    public $test;

    public $total_question = 0;

    public $total_marks = 0;

    public $correct_answer = 0;

    public $incorrect_answer = 0;

    public $not_attempted = 0;

    public $negative_marks = 0;

    public $out_of_marks = 0;

    public $final_marks = 0;

    public function mount($student_id, $test_id)
    {
        $this->studentId = $student_id;
        $this->testId = $test_id;

        $this->test = TestModal::find($this->testId);

        if (empty($this->test) || Auth::id() != $this->studentId) {
            return redirect()->route('student.dashboard');
        }

        $this->calculateResult();
    }

    protected function calculateResult(): void
    {
        $test_response = Gn_Test_Response::where('student_id', $this->studentId)
            ->where('test_id', $this->testId)
            ->get()
            ->keyBy('question_id');

        // Fetch ALL questions for this test to calculate total correctly
        $allQuestions = $this->test->getQuestions()->get();
        $this->total_question = $allQuestions->count();

        foreach ($allQuestions as $question) {
            $response = $test_response->get($question->id);

            if ($response && ($response->answer !== null && $response->answer !== '')) {
                if ($question->mcq_answer === $response->answer) {
                    $this->correct_answer++;
                } else {
                    $this->incorrect_answer++;
                }
            } else {
                // No response or empty answer = Not Attempted!
                $this->not_attempted++;
            }
        }

        $marksPerQ = $this->test->gn_marks_per_questions ?? 1;
        $this->total_marks = $this->total_question * $marksPerQ;

        $negativeMarkRate = (($this->test->negative_marks ?? 0) * $marksPerQ);
        $this->negative_marks = $this->incorrect_answer * $negativeMarkRate;
        $this->out_of_marks = $this->correct_answer * $marksPerQ;
        $this->final_marks = $this->out_of_marks - $this->negative_marks;
    }

    public function render()
    {
        return view('livewire.student.tests.show-result');
    }
}
