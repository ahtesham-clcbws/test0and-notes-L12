<?php

namespace App\Livewire\Admin\Tests;

use App\Models\QuestionBankModel;
use App\Models\TestModal;
use App\Models\TestQuestions;
use App\Models\TestSections;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class TestQuestionsManager extends Component
{
    use WithPagination;

    public $testId;
    public $sectionId;
    public $test;
    public $section;
    public $totalAllowed = 0;
    public $currentlyAssigned = 0;

    // New Question Modal Properties
    public $showAddModal = false;
    public $newQuestion = [
        'question' => '',
        'question_type' => 1,
        'ans_1' => '',
        'ans_2' => '',
        'ans_3' => '',
        'ans_4' => '',
        'ans_5' => '',
        'mcq_answer' => 'ans_1',
        'solution' => '',
        'explanation' => '',
    ];

    protected $listeners = ['questionAdded' => '$refresh', 'questionRemoved' => '$refresh'];

    public function mount($test_id, $section_id)
    {
        $this->testId = $test_id;
        $this->sectionId = $section_id;

        $this->test = TestModal::findOrFail($this->testId);
        $this->section = TestSections::findOrFail($this->sectionId);
        $this->totalAllowed = $this->section->number_of_questions;

        $this->updateCounts();
    }

    public function updateCounts()
    {
        // Re-calculate the number of assigned questions
        $this->currentlyAssigned = TestQuestions::where('test_id', $this->testId)
            ->where('section_id', $this->sectionId)
            ->count();
    }

    public function getAssignedQuestionsProperty()
    {
        // Get already assigned questions for the top table
        return TestQuestions::where('test_id', $this->testId)
            ->where('section_id', $this->sectionId)
            ->with(['question.classGroup', 'question_creator'])
            ->get();
    }

    public function getAvailableQuestionsProperty()
    {
        // Match questions strictly based on Section's subject criteria
        // as requested: "matching subject & part, nothing else"
        $query = QuestionBankModel::query();

        if ($this->section->subject) {
            $query->where('subject', $this->section->subject);
        }

        if ($this->section->subject_part) {
            $query->where('subject_part', $this->section->subject_part);
        }

        // Filter out those already added to THIS section explicitly

        // (Requirements said it's okay to add to another section, but not duplicate in THIS section)
        $alreadyAssignedIds = TestQuestions::where('section_id', $this->sectionId)
            ->pluck('question_id')
            ->toArray();

        $query->whereNotIn('id', $alreadyAssignedIds);

        return $query->paginate(15);
    }

    public function addQuestion($questionId)
    {
        $this->updateCounts();

        if ($this->currentlyAssigned >= $this->totalAllowed) {
            session()->flash('error', 'You have reached the maximum number of questions for this section.');

            return;
        }

        // Double check not already assigned to this section
        $exists = TestQuestions::where('section_id', $this->sectionId)
            ->where('question_id', $questionId)
            ->exists();

        if ($exists) {
            session()->flash('error', 'Question is already assigned to this section.');

            return;
        }

        $question = QuestionBankModel::findOrFail($questionId);

        TestQuestions::create([
            'test_id' => $this->testId,
            'section_id' => $this->sectionId,
            'creator_id' => $question->creator_id ?? Auth::id(), // Use question creator, fallback to auth
            'question_id' => $questionId,
            'allotter_id' => Auth::id(),
        ]);

        $this->updateCounts();
        session()->flash('success', 'Question added successfully.');
    }

    public function removeQuestion($mappingId)
    {
        $mapping = TestQuestions::where('id', $mappingId)
            ->where('section_id', $this->sectionId)
            ->first();

        if ($mapping) {
            $mapping->delete();
            $this->updateCounts();
            session()->flash('success', 'Question removed from section.');
        }
    }

    public function openAddModal()
    {
        $this->resetErrorBag();
        $this->newQuestion = [
            'question' => '',
            'question_type' => 1,
            'ans_1' => '',
            'ans_2' => '',
            'ans_3' => '',
            'ans_4' => '',
            'ans_5' => '',
            'mcq_answer' => 'ans_1',
            'solution' => '',
            'explanation' => '',
        ];
        $this->showAddModal = true;
    }

    public function closeAddModal()
    {
        $this->showAddModal = false;
    }

    public function saveNewQuestion()
    {
        $this->validate([
            'newQuestion.question' => 'required',
            'newQuestion.question_type' => 'required',
            'newQuestion.mcq_answer' => 'required_if:newQuestion.question_type,1',
        ]);

        $data = $this->newQuestion;
        $data['education_type_id'] = $this->test->education_type_id;
        $data['class_group_exam_id'] = $this->test->education_type_child_id;
        $data['board_agency_state_id'] = $this->test->board_state_agency;
        $data['subject'] = $this->section->subject;
        $data['subject_part'] = $this->section->subject_part;
        $data['subject_lesson_chapter'] = $this->section->subject_part_lesson;
        $data['status'] = 'approved';
        $data['creator_id'] = Auth::id();

        $question = QuestionBankModel::create($data);

        $this->addQuestion($question->id);
        
        $this->showAddModal = false;
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Question created and attached successfully!']);
    }

    #[Layout('Layouts.admin')]
    public function render()
    {
        return view('livewire.admin.tests.test-questions-manager', [
            'assignedQuestions' => $this->assignedQuestions,
            'availableQuestions' => $this->availableQuestions,
        ]);
    }
}
