<?php

namespace App\Livewire\Student\Tests;

use App\Models\Gn_StudentTestAttempt;
use App\Models\Gn_Test_Response;
use App\Models\QuestionBankModel;
use App\Models\TestModal;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('Layouts.frontend')]
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

    public function mount($testId)
    {
        $this->testId = $testId;
        $this->test = TestModal::findOrFail($testId);

        $attempt = Gn_StudentTestAttempt::where('student_id', Auth::id())
            ->where('test_id', $testId)
            ->first();

        if ($attempt && $attempt->status === 'completed') {
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

        // timeRemaining = (created_at + duration_mins) - now()
        $startedAt = $attempt->created_at;
        $expiryTime = $startedAt->addMinutes($totalDuration ?? 0);
        $this->timeLeft = max(0, now()->diffInSeconds($expiryTime, false));

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
        
        if (!empty($this->questionsList)) {
            $currentQId = $this->getCurrentQuestionId();
            if ($currentQId && !in_array($currentQId, $this->visitedQuestions)) {
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
        if ($currentQId && !in_array($currentQId, $this->visitedQuestions)) {
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
                ])
            ]);
        }
    }

    public function saveAndNext()
    {
        $secQuestions = $this->questionsList[$this->currentSectionIndex] ?? [];
        if ($this->currentQuestionIndex < count($secQuestions) - 1) {
            $this->currentQuestionIndex++;
        } else {
            if ($this->currentSectionIndex < count($this->sections) - 1) {
                $this->currentSectionIndex++;
                $this->currentQuestionIndex = 0;
            } else {
                // Absolute end of test: Increment index beyond questions length to trigger Summary view!
                $this->currentQuestionIndex++;
                return;
            }
        }

        $currentQId = $this->getCurrentQuestionId();
        if ($currentQId && !in_array($currentQId, $this->visitedQuestions)) {
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

    public function render()
    {
        $currentQId = $this->getCurrentQuestionId();
        $currentQuestion = $currentQId ? QuestionBankModel::find($currentQId) : null;

        return view('livewire.student.tests.online-test-runner', [
            'currentQuestion' => $currentQuestion,
        ]);
    }
}
