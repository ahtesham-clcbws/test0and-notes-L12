<?php

namespace App\Livewire\Student\Tests;

use App\Models\Gn_Test_Response;
use App\Models\QuestionBankModel;
use App\Models\TestModal;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

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
            ->get();

        $questions = QuestionBankModel::whereIn('id', $test_response->pluck('question_id')->toArray())
            ->get()
            ->keyBy('id');

        $this->total_question = $test_response->count();

        foreach ($test_response as $response) {
            $question = $questions->get($response->question_id);
            if ($question) {
                if ($response->answer === null || $response->answer === '') {
                    $this->not_attempted++;
                } elseif ($question->mcq_answer === $response->answer) {
                    $this->correct_answer++;
                } else {
                    $this->incorrect_answer++;
                }
            } else {
                // If question isn't found in mapping, count as not_attempted to be safe
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
        return view('livewire.student.tests.show-result')
            ->extends('Layouts.student', [
                'data' => [
                    'pagename' => ($this->test->title ?? 'Test') . ' - Result',
                    'pageicon' => 'file-earmark-check'
                ]
            ])
            ->section('main');
    }
}
