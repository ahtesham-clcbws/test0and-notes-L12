<?php

namespace App\Livewire\Student\Tests;

use App\Models\Gn_StudentTestAttempt;
use App\Models\Gn_Test_Response;
use App\Models\QuestionBankModel;
use App\Models\TestModal;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.student-exam-mary')]
class OnlineTestRunner extends Component
{
    public $testId;

    public $test;

    public $sections = [];

    public $currentSectionIndex = 0;

    public $currentQuestionIndex = 0;

    public $questionsList = []; // Array of Question IDs for the current view/section

    public $answers = []; // ['question_id' => 'answer']

    public $markedQuestions = []; // ['question_id']

    public $visitedQuestions = []; // ['question_id']

    public $timeLeft = 0;

    public $attemptId;

    // Set initial view state to instructions (Restore instructions page after terms)
    public $currentView = 'instructions'; // 'instructions', 'testing', 'review'

    public $endTimestamp; // Stable timestamp for JS to count down to

    public function mount($testId)
    {
        $this->testId = $testId;
        $this->test = TestModal::findOrFail($testId);

        $attempt = Gn_StudentTestAttempt::where('student_id', Auth::id())
            ->where('test_id', $testId)
            ->first();

        if ($attempt && $attempt->status === 'completed') {
            $responsesCount = Gn_Test_Response::where('student_id', Auth::id())
                ->where('test_id', $testId)
                ->count();

            if ($responsesCount === 0) {
                // False completion triggered by timing glitches: Reset to running with a fresh start
                $attempt->update(['status' => 'running', 'created_at' => now()]);
            } else {
                return redirect()->route('student.show-result', [Auth::id(), $testId]);
            }
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
            // If already exists but no answers yet, reset created_at to now() to give full time for fresh starts/tests
            $responsesCount = Gn_Test_Response::where('student_id', Auth::id())
                ->where('test_id', $testId)
                ->count();

            if ($responsesCount === 0 && $attempt->status === 'running') {
                $attempt->update(['created_at' => now()]);
            }
        }

        $this->attemptId = $attempt->id;

        // Load existing answers on re-hydration
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
            $totalDuration = array_sum($timeArray); // Assuming minutes
        }

        // Safety Fallback to prevent immediate auto-submission on 0 duration
        if (! $totalDuration || $totalDuration <= 0) {
            $totalDuration = 60; // 60 minutes default for test configurations missing durations
        }

        // timeRemaining = (created_at + duration_mins) - now()
        $startedAt = $attempt->created_at;
        $expiryTime = $startedAt->addMinutes($totalDuration ?? 0);
        $this->timeLeft = max(0, now()->diffInSeconds($expiryTime, false));
        $this->endTimestamp = $expiryTime->timestamp * 1000; // Milliseconds for JS

        if ($this->timeLeft <= 0) {
            $this->submitTest();

            return;
        }

        // Load Sections & Questions Grouped
        $this->loadQuestionsStructure();
    }

    protected function loadQuestionsStructure(): void
    {
        $this->sections = $this->test->testSections()->with('sectionSubject')->get()->toArray();

        $questions = $this->test->getQuestions()->get()->groupBy('pivot.section_id');

        foreach ($this->sections as $key => $section) {
            $sectionId = $section['id'];
            $this->questionsList[$key] = $questions->has($sectionId)
                ? $questions[$sectionId]->pluck('id')->toArray()
                : [];
        }

        // Safety: Start at the first section that actually has questions
        foreach ($this->questionsList as $key => $qIds) {
            if (! empty($qIds)) {
                $this->currentSectionIndex = $key;
                break;
            }
        }

        if (! empty($this->questionsList)) {
            $currentQId = $this->getCurrentQuestionId();
            if ($currentQId && ! in_array($currentQId, $this->visitedQuestions)) {
                $this->visitedQuestions[] = $currentQId;
                $this->updateDraftState();
            }
        }
    }

    public function getCurrentQuestionId()
    {
        return $this->questionsList[$this->currentSectionIndex][$this->currentQuestionIndex] ?? null;
    }

    public function selectQuestion($secIndex, $qIndex)
    {
        $this->currentSectionIndex = $secIndex;
        $this->currentQuestionIndex = $qIndex;

        $currentQId = $this->getCurrentQuestionId();
        if ($currentQId && ! in_array($currentQId, $this->visitedQuestions)) {
            $this->visitedQuestions[] = $currentQId;
            $this->updateDraftState();
        }
    }

    public function saveSelection($questionId, $answer)
    {
        $this->answers[$questionId] = $answer;

        Gn_Test_Response::updateOrCreate(
            ['student_id' => Auth::id(), 'test_id' => $this->testId, 'question_id' => $questionId],
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

    protected function updateDraftState(): void
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
                // Absolute end of test: Increment index beyond questions length to trigger Summary view!
                $this->currentQuestionIndex = count($secQuestions);

                return;
            }
        }

        $currentQId = $this->getCurrentQuestionId();
        if ($currentQId && ! in_array($currentQId, $this->visitedQuestions)) {
            $this->visitedQuestions[] = $currentQId;
            $this->updateDraftState();
        }
    }

    public function verifyTimerStatus()
    {
        $attempt = Gn_StudentTestAttempt::find($this->attemptId);
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

        $expiryTime = $attempt->created_at->addMinutes($totalDuration ?? 0);
        $this->timeLeft = max(0, now()->diffInSeconds($expiryTime, false));

        if ($this->timeLeft <= 0) {
            $this->submitTest();
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

    public function startTest()
    {
        $this->currentView = 'testing';
    }

    public function goToReview()
    {
        $this->currentView = 'review';
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
