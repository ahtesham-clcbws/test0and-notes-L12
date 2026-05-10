<?php

namespace App\Livewire\Student\Tests;

use App\Models\Gn_StudentTestAttempt;
use App\Models\Gn_Test_Response;
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

    // State for Summary Modal (Replaces 'review' view for 1:1 parity with old modal)
    public bool $showSummaryModal = false;

    public $currentView = 'testing'; // Default to testing as instructions are now separate

    public $endTimestamp;

    public function mount($testId)
    {
        $this->testId = $testId;
        $this->test = TestModal::findOrFail($testId);

        $attempt = Gn_StudentTestAttempt::where('student_id', Auth::id())
            ->where('test_id', $testId)
            ->first();

        // RESUME LOGIC: Only redirect to result if the attempt is NOT 'running'
        if ($attempt && $attempt->status !== 'running') {
            return redirect()->route('student.show-result', [Auth::id(), $testId]);
        }

        if (! $attempt) {
            $attempt = Gn_StudentTestAttempt::create([
                'student_id' => Auth::id(),
                'test_id' => $testId,
                'test_attempt' => 1,
                'status' => 'running',
                'draft_state' => json_encode(['visited' => [], 'marked_for_review' => []]),
            ]);
        } else {
            // STALE ATTEMPT PROTECTION:
            // If the attempt is 'running' but has ZERO answers, reset the created_at to now.
            // This prevents students from being locked out if they accidentally started a test long ago.
            $responsesCount = Gn_Test_Response::where('student_id', Auth::id())
                ->where('test_id', $testId)
                ->count();

            if ($responsesCount === 0 && $attempt->status === 'running') {
                $attempt->update(['created_at' => now()]);
            }
        }

        $this->attemptId = $attempt->id;

        // Load existing answers on re-hydration (Persistence)
        $existingResponses = Gn_Test_Response::where('student_id', Auth::id())
            ->where('test_id', $this->testId)
            ->get();

        foreach ($existingResponses as $response) {
            $this->answers[$response->question_id] = $response->answer;
        }

        // Load draft_state (Markers, Visited)
        if ($attempt->draft_state) {
            $draft = json_decode($attempt->draft_state, true);
            $this->markedQuestions = $draft['marked_for_review'] ?? [];
            $this->visitedQuestions = $draft['visited'] ?? [];
        }

        // Calculate Timer based on original start time
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
            $totalDuration = 60; // 60 minutes safety default
        }

        $this->endTimestamp = ($attempt->created_at->timestamp + ($totalDuration * 60)) * 1000;

        $this->loadQuestionsStructure();
        
        // Ensure current question is marked as visited
        $currentQId = $this->getCurrentQuestionId();
        if ($currentQId && ! in_array($currentQId, $this->visitedQuestions)) {
            $this->visitedQuestions[] = $currentQId;
            $this->updateDraftState();
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
            $this->updateDraftState();
        }
    }

    public function getCurrentQuestionId()
    {
        return $this->questionsList[$this->currentSectionIndex][$this->currentQuestionIndex] ?? null;
    }

    public function saveSelection($questionId, $answer)
    {
        $this->answers[$questionId] = $answer;

        Gn_Test_Response::updateOrCreate(
            [
                'student_id' => Auth::id(),
                'test_id' => $this->testId,
                'question_id' => $questionId,
            ],
            ['answer' => $answer]
        );
    }

    public function clearResponse($questionId)
    {
        unset($this->answers[$questionId]);

        Gn_Test_Response::where('student_id', Auth::id())
            ->where('test_id', $this->testId)
            ->where('question_id', $questionId)
            ->delete();
    }

    public function toggleMarkForReview($questionId)
    {
        if (in_array($questionId, $this->markedQuestions)) {
            $this->markedQuestions = array_values(array_diff($this->markedQuestions, [$questionId]));
        } else {
            $this->markedQuestions[] = $questionId;
        }

        $this->updateDraftState();
    }

    public function updateDraftState()
    {
        $attempt = Gn_StudentTestAttempt::find($this->attemptId);
        if ($attempt) {
            $attempt->update([
                'draft_state' => json_encode([
                    'visited' => $this->visitedQuestions,
                    'marked_for_review' => $this->markedQuestions,
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
            // Must jump to next section that HAS questions
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
                // Absolute end of test: Show Summary Modal
                $this->showSummaryModal = true;
                return;
            }
        }

        $currentQId = $this->getCurrentQuestionId();
        if ($currentQId && ! in_array($currentQId, $this->visitedQuestions)) {
            $this->visitedQuestions[] = $currentQId;
            $this->updateDraftState();
        }
    }

    public function submitTest()
    {
        $attempt = Gn_StudentTestAttempt::find($this->attemptId);
        if ($attempt) {
            $attempt->update(['status' => 'completed']);
        }

        return redirect()->route('student.show-result', [Auth::id(), $this->testId]);
    }

    public function toggleSummaryModal()
    {
        $this->showSummaryModal = ! $this->showSummaryModal;
    }

    public function goToReview()
    {
        $this->showSummaryModal = true;
    }

    public function render()
    {
        $currentQId = $this->getCurrentQuestionId();
        $currentQuestion = $currentQId ? QuestionBankModel::find($currentQId) : null;

        // Calculate counts for Review View
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
