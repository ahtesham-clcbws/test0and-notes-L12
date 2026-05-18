<?php

namespace App\Livewire\Student\Tests;

use App\Models\QuestionBankModel;
use App\Models\TestAttempt;
use App\Models\TestAttemptAnswer;
use App\Models\TestModal;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('components.layouts.student-exam-mary')]
class OnlineTestRunner extends Component
{
    public int $testId;

    public ?TestModal $test = null;

    public array $sections = [];

    #[Url]
    public int $currentSectionIndex = 0;

    #[Url]
    public int $currentQuestionIndex = 0;

    public array $questionsList = []; // Array of Question IDs for the current view/section

    public array $answers = []; // ['question_id' => 'answer']

    public array $markedQuestions = []; // ['question_id']

    public array $visitedQuestions = []; // ['question_id']

    public int|string $timeLeft = 0;

    public ?int $attemptId = null;

    public bool $showSummaryModal = false;

    public bool $showQuestionsModal = false;

    public bool $showInstructionsModal = false;

    public bool $showSkipConfirmationModal = false;

    public int $endTimestamp = 0;

    public function mount(int|string $testId)
    {
        $this->testId = (int) $testId;
        $this->test = TestModal::findOrFail($this->testId);

        $attempt = TestAttempt::where('student_id', Auth::id())
            ->where('test_id', $this->testId)
            ->first();

        // RESUME LOGIC: Only redirect to result if the attempt is NOT 'running'
        if ($attempt) {
            $attempt->checkAndHandleExpiry();
            if ($attempt->status !== 'running') {
                $payload = \Illuminate\Support\Facades\Crypt::encrypt([
                    'student_id' => Auth::id(),
                    'test_id' => $this->testId,
                    'mode' => 'result',
                ]);

                return redirect()->route('student.show-result', ['payload' => $payload]);
            }
        }

        if (! $attempt) {
            $attempt = TestAttempt::create([
                'student_id' => Auth::id(),
                'test_id' => $this->testId,
                'test_attempt' => 1,
                'status' => 'running',
                'is_in_review' => 0,
                'draft_state' => [
                    'current_section' => 0,
                    'current_question' => 0,
                ],
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
        if ($attempt->draft_state && is_array($attempt->draft_state)) {
            $draft = $attempt->draft_state;
            if (! request()->has('currentSectionIndex')) {
                $this->currentSectionIndex = (int) ($draft['current_section'] ?? 0);
            }
            if (! request()->has('currentQuestionIndex')) {
                $this->currentQuestionIndex = (int) ($draft['current_question'] ?? 0);
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

    public function loadQuestionsStructure(): void
    {
        $this->sections = $this->test->testSections()->with(['sectionSubject', 'sectionSubjectPart'])->get()->toArray();

        foreach ($this->sections as $index => $section) {
            $this->questionsList[$index] = $this->test->getQuestions()
                ->where('section_id', $section['id'])
                ->distinct()
                ->pluck('question_bank.id')
                ->toArray();
        }
    }

    public function selectQuestion(int|string $sectionIndex, int|string $questionIndex): void
    {
        $this->currentSectionIndex = (int) $sectionIndex;
        $this->currentQuestionIndex = (int) $questionIndex;

        $currentQId = $this->getCurrentQuestionId();
        if ($currentQId && ! in_array($currentQId, $this->visitedQuestions)) {
            $this->visitedQuestions[] = $currentQId;
            $this->syncQuestionState($currentQId);
        }

        $this->updatePosition();
    }

    public function getCurrentQuestionId(): ?int
    {
        return $this->questionsList[$this->currentSectionIndex][$this->currentQuestionIndex] ?? null;
    }

    public function syncQuestionState(int|string $questionId): void
    {
        TestAttemptAnswer::updateOrCreate(
            [
                'test_attempt_id' => $this->attemptId,
                'question_id' => (int) $questionId,
            ],
            [
                'answer' => $this->answers[(int) $questionId] ?? null,
                'is_visited' => in_array((int) $questionId, $this->visitedQuestions) ? 1 : 0,
                'is_marked_for_review' => in_array((int) $questionId, $this->markedQuestions) ? 1 : 0,
            ]
        );
    }

    public function saveSelection(int|string $questionId, string $answer): void
    {
        $this->answers[(int) $questionId] = $answer;
        $this->syncQuestionState((int) $questionId);
        $this->updatePosition();
    }

    public function clearResponse(int|string $questionId): void
    {
        unset($this->answers[(int) $questionId]);
        $this->syncQuestionState((int) $questionId);
        $this->updatePosition();
    }

    public function toggleMarkForReview(int|string $questionId): void
    {
        if (in_array((int) $questionId, $this->markedQuestions)) {
            $this->markedQuestions = array_values(array_diff($this->markedQuestions, [(int) $questionId]));
        } else {
            $this->markedQuestions[] = (int) $questionId;
        }

        $this->syncQuestionState((int) $questionId);
        $this->updatePosition();
    }

    public function updatePosition(): void
    {
        $attempt = TestAttempt::find($this->attemptId);
        if ($attempt) {
            $currentQId = $this->getCurrentQuestionId();
            $currentSecId = $this->sections[$this->currentSectionIndex]['id'] ?? null;

            $attempt->update([
                'last_section_id' => $currentSecId,
                'last_question_id' => $currentQId,
                'draft_state' => [
                    'current_section' => $this->currentSectionIndex,
                    'current_question' => $this->currentQuestionIndex,
                ],
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

        $payload = \Illuminate\Support\Facades\Crypt::encrypt([
            'student_id' => Auth::id(),
            'test_id' => $this->testId,
            'mode' => 'result',
        ]);

        return redirect()->route('student.show-result', ['payload' => $payload]);
    }

    public function confirmSkipAndNext(): void
    {
        $this->showSkipConfirmationModal = false;
        $this->saveAndNext();
    }

    public function goToReview()
    {
        $attempt = TestAttempt::find($this->attemptId);
        if ($attempt) {
            $attempt->update(['is_in_review' => 1]);
        }

        $payload = \Illuminate\Support\Facades\Crypt::encrypt([
            'student_id' => Auth::id(),
            'test_id' => $this->testId,
            'mode' => 'review',
        ]);

        return redirect()->route('student.test-review', ['payload' => $payload]);
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
