<?php

namespace App\Livewire\Student\Tests;

use App\Models\TestAttempt;
use App\Models\TestAttemptAnswer;
use App\Models\QuestionBankModel;
use App\Models\TestModal;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('components.layouts.student-exam-mary')]
class OnlineTestRunner extends Component
{
    public $testId;

    public $test;

    public $sections = [];

    #[Url]
    public $currentSectionIndex = 0;

    #[Url]
    public $currentQuestionIndex = 0;

    public $questionsList = []; // Array of Question IDs for the current view/section

    public $answers = []; // ['question_id' => 'answer']

    public $markedQuestions = []; // ['question_id']

    public $visitedQuestions = []; // ['question_id']

    public $timeLeft = 0;

    public $attemptId;

    public bool $showSummaryModal = false;

    public $endTimestamp;

    public function mount($testId)
    {
        $this->testId = $testId;
        $this->test = TestModal::findOrFail($testId);

        $attempt = TestAttempt::where('student_id', Auth::id())
            ->where('test_id', $testId)
            ->first();

        // RESUME LOGIC: Only redirect to result if the attempt is NOT 'running'
        if ($attempt && $attempt->status !== 'running') {
            return redirect()->route('student.show-result', [Auth::id(), $testId]);
        }

        if (! $attempt) {
            $attempt = TestAttempt::create([
                'student_id' => Auth::id(),
                'test_id' => $testId,
                'test_attempt' => 1,
                'status' => 'running',
                'is_in_review' => 0,
                'draft_state' => json_encode([
                    'current_section' => 0,
                    'current_question' => 0
                ]),
            ]);
        } else {
            // STALE ATTEMPT PROTECTION
            $responsesCount = TestAttemptAnswer::where('test_attempt_id', $attempt->id)->count();

            if ($responsesCount === 0 && $attempt->status === 'running') {
                $attempt->update(['created_at' => now()]);
            }
        }

        $this->attemptId = $attempt->id;

        // Load existing answers and states directly from DB tracking table
        $existingResponses = TestAttemptAnswer::where('test_attempt_id', $this->attemptId)->get();

        foreach ($existingResponses as $response) {
            if ($response->answer) {
                $this->answers[$response->question_id] = $response->answer;
            }
            if ($response->is_visited) {
                $this->visitedQuestions[] = $response->question_id;
            }
            if ($response->is_marked_for_review) {
                $this->markedQuestions[] = $response->question_id;
            }
        }

        // Restore Position
        if ($attempt->draft_state) {
            $draft = json_decode($attempt->draft_state, true);
            if (!request()->has('currentSectionIndex')) {
                $this->currentSectionIndex = $draft['current_section'] ?? 0;
            }
            if (!request()->has('currentQuestionIndex')) {
                $this->currentQuestionIndex = $draft['current_question'] ?? 0;
            }
        }

        // Restore Review State
        if ($attempt->is_in_review) {
            $this->showSummaryModal = true;
        }

        // Calculate Timer
        $totalDuration = $this->test->time_to_complete;
        if (! $totalDuration) {
            $section_time = $this->test->testSections()
                ->select('number_of_questions', 'duration')
                ->get()
                ->toArray();

            $timeArray = [];
            foreach ($section_time as $section) {
                $timeArray[] = $section['number_of_questions'] * $section['duration'];
            }
            $totalDuration = array_sum($timeArray);
        }

        if (! $totalDuration || $totalDuration <= 0) {
            $totalDuration = 60; // 60 minutes default
        }

        $expiryTime = $attempt->created_at->timestamp + ($totalDuration * 60);
        if (now()->timestamp >= $expiryTime) {
            return $this->submitTest();
        }

        $this->endTimestamp = $expiryTime * 1000;

        $this->loadQuestionsStructure();
        
        $currentQId = $this->getCurrentQuestionId();
        if ($currentQId && ! in_array($currentQId, $this->visitedQuestions)) {
            $this->visitedQuestions[] = $currentQId;
            $this->syncQuestionState($currentQId);
            $this->updatePosition();
        }
    }

    public function loadQuestionsStructure()
    {
        $this->sections = $this->test->testSections()->with('sectionSubject')->get()->toArray();

        foreach ($this->sections as $index => $section) {
            $this->questionsList[$index] = $this->test->getQuestions()
                ->where('section_id', $section['id'])
                ->distinct()
                ->pluck('question_bank.id')
                ->toArray();
        }
    }

    public function selectQuestion($sectionIndex, $questionIndex)
    {
        $this->currentSectionIndex = $sectionIndex;
        $this->currentQuestionIndex = $questionIndex;

        $currentQId = $this->getCurrentQuestionId();
        if ($currentQId && ! in_array($currentQId, $this->visitedQuestions)) {
            $this->visitedQuestions[] = $currentQId;
            $this->syncQuestionState($currentQId);
        }
        
        $this->updatePosition();
    }

    public function getCurrentQuestionId()
    {
        return $this->questionsList[$this->currentSectionIndex][$this->currentQuestionIndex] ?? null;
    }

    public function syncQuestionState($questionId)
    {
        TestAttemptAnswer::updateOrCreate(
            [
                'test_attempt_id' => $this->attemptId,
                'question_id' => $questionId,
            ],
            [
                'answer' => $this->answers[$questionId] ?? null,
                'is_visited' => in_array($questionId, $this->visitedQuestions) ? 1 : 0,
                'is_marked_for_review' => in_array($questionId, $this->markedQuestions) ? 1 : 0,
            ]
        );
    }

    public function saveSelection($questionId, $answer)
    {
        $this->answers[$questionId] = $answer;
        $this->syncQuestionState($questionId);
        $this->updatePosition();
    }

    public function clearResponse($questionId)
    {
        unset($this->answers[$questionId]);
        $this->syncQuestionState($questionId);
        $this->updatePosition();
    }

    public function toggleMarkForReview($questionId)
    {
        if (in_array($questionId, $this->markedQuestions)) {
            $this->markedQuestions = array_values(array_diff($this->markedQuestions, [$questionId]));
        } else {
            $this->markedQuestions[] = $questionId;
        }

        $this->syncQuestionState($questionId);
        $this->updatePosition();
    }

    public function updatePosition()
    {
        $attempt = TestAttempt::find($this->attemptId);
        if ($attempt) {
            $currentQId = $this->getCurrentQuestionId();
            $currentSecId = $this->sections[$this->currentSectionIndex]['id'] ?? null;
            
            $attempt->update([
                'last_section_id' => $currentSecId,
                'last_question_id' => $currentQId,
                'draft_state' => json_encode([
                    'current_section' => $this->currentSectionIndex,
                    'current_question' => $this->currentQuestionIndex,
                ]),
            ]);
        }
    }

    public function saveAndNext()
    {
        $secQuestions = $this->questionsList[$this->currentSectionIndex] ?? [];
        if ($this->currentQuestionIndex < count($secQuestions) - 1) {
            $this->currentQuestionIndex++;
        } else {
            $nextSecIndex = $this->currentSectionIndex + 1;
            while ($nextSecIndex < count($this->sections)) {
                if (! empty($this->questionsList[$nextSecIndex] ?? [])) {
                    $this->currentSectionIndex = $nextSecIndex;
                    $this->currentQuestionIndex = 0;
                    break;
                }
                $nextSecIndex++;
            }

            if ($nextSecIndex >= count($this->sections)) {
                $this->goToReview();
                return;
            }
        }

        $currentQId = $this->getCurrentQuestionId();
        if ($currentQId && ! in_array($currentQId, $this->visitedQuestions)) {
            $this->visitedQuestions[] = $currentQId;
            $this->syncQuestionState($currentQId);
        }
        
        $this->updatePosition();
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

        return redirect()->route('student.show-result', [Auth::id(), $this->testId]);
    }

    public function toggleSummaryModal()
    {
        $this->showSummaryModal = ! $this->showSummaryModal;
        
        $attempt = TestAttempt::find($this->attemptId);
        if ($attempt) {
            $attempt->update(['is_in_review' => $this->showSummaryModal ? 1 : 0]);
        }
    }

    public function goToReview()
    {
        $this->showSummaryModal = true;
        
        $attempt = TestAttempt::find($this->attemptId);
        if ($attempt) {
            $attempt->update(['is_in_review' => 1]);
        }
        
        $this->updatePosition();
    }

    public function render()
    {
        $currentQId = $this->getCurrentQuestionId();
        $currentQuestion = $currentQId ? QuestionBankModel::find($currentQId) : null;

        $totalQuestions = 0;
        foreach ($this->questionsList as $qIds) {
            $totalQuestions += count($qIds);
        }
        $attemptedCount = count($this->answers);
        $reviewCount = count($this->markedQuestions);
        $notAttemptedCount = $totalQuestions - $attemptedCount;

        return view('livewire.student.tests.online-test-runner', [
            'currentQuestion' => $currentQuestion,
            'totalQuestions' => $totalQuestions,
            'attemptedCount' => $attemptedCount,
            'reviewCount' => $reviewCount,
            'notAttemptedCount' => $notAttemptedCount,
        ]);
    }
}
