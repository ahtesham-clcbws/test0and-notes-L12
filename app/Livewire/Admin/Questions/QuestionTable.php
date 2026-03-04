<?php

namespace App\Livewire\Admin\Questions;

use App\Models\BoardAgencyStateModel;
use App\Models\ClassGoupExamModel;
use App\Models\Educationtype;
use App\Models\QuestionBankModel;
use App\Models\Subject;
use App\Models\SubjectPart;
use App\Models\SubjectPartLesson;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('Layouts.admin')]
class QuestionTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';

    public $education_type_id = '';

    public $class_id = '';

    public $board_id = '';

    public $subject_id = '';

    public $part_id = '';

    public $lesson_id = '';

    public $statusFilter = '';

    public $question_type = '';

    public $selectedRows = [];

    public $selectAll = false;

    public $educationTypes = [];

    public $classes = [];

    public $boards = [];

    public $subjects = [];

    public $parts = [];

    public $lessons = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'education_type_id' => ['except' => ''],
        'class_id' => ['except' => ''],
        'board_id' => ['except' => ''],
        'subject_id' => ['except' => ''],
        'statusFilter' => ['except' => ''],
    ];

    public function mount()
    {
        $this->educationTypes = Educationtype::all();
        if ($this->education_type_id) {
            $this->classes = ClassGoupExamModel::where('education_type_id', $this->education_type_id)->get();
        }
        if ($this->class_id) {
            $this->boards = BoardAgencyStateModel::where('class_group_exam_id', $this->class_id)->get();
            $this->subjects = Subject::where('class_id', $this->class_id)->get();
        }
    }

    public function updatedEducationTypeId($value)
    {
        $this->classes = $value ? ClassGoupExamModel::where('education_type_id', $value)->get() : [];
        $this->reset(['class_id', 'board_id', 'subject_id', 'part_id', 'lesson_id', 'boards', 'subjects', 'parts', 'lessons']);
        $this->resetPage();
    }

    public function updatedClassId($value)
    {
        $this->boards = $value ? BoardAgencyStateModel::where('class_group_exam_id', $value)->get() : [];
        $this->subjects = $value ? Subject::where('class_id', $value)->get() : [];
        $this->reset(['board_id', 'subject_id', 'part_id', 'lesson_id', 'parts', 'lessons']);
        $this->resetPage();
    }

    public function updatedSubjectId($value)
    {
        $this->parts = $value ? SubjectPart::where('subject_id', $value)->get() : [];
        $this->reset(['part_id', 'lesson_id', 'lessons']);
        $this->resetPage();
    }

    public function updatedPartId($value)
    {
        $this->lessons = $value ? SubjectPartLesson::where('subject_part_id', $value)->get() : [];
        $this->reset(['lesson_id']);
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function deleteQuestion($id)
    {
        QuestionBankModel::find($id)->delete();
        $this->dispatch('notify', type: 'success', message: 'Question deleted successfully.');
    }

    public function updateStatus($id, $status)
    {
        $question = QuestionBankModel::find($id);
        $question->status = $status;
        $question->save();
        $this->dispatch('notify', type: 'success', message: 'Question status updated to '.$status);
    }

    public function bulkUpdateStatus($status)
    {
        QuestionBankModel::whereIn('id', $this->selectedRows)->update(['status' => $status]);
        $this->selectedRows = [];
        $this->selectAll = false;
        $this->dispatch('notify', type: 'success', message: 'Selected questions updated to '.$status);
    }

    public function bulkDelete()
    {
        QuestionBankModel::whereIn('id', $this->selectedRows)->delete();
        $this->selectedRows = [];
        $this->selectAll = false;
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Selected questions deleted.']);
    }

    private function filteredQuery()
    {
        return QuestionBankModel::query()
            ->when($this->search, function ($q) {
                return $q->where('question', 'like', '%'.$this->search.'%');
            })
            ->when($this->education_type_id, function ($q) {
                return $q->where('education_type_id', $this->education_type_id);
            })
            ->when($this->class_id, function ($q) {
                return $q->where('class_group_exam_id', $this->class_id);
            })
            ->when($this->subject_id, function ($q) {
                return $q->where('subject', $this->subject_id);
            })
            ->when($this->part_id, function ($q) {
                return $q->where('subject_part', $this->part_id);
            })
            ->when($this->lesson_id, function ($q) {
                return $q->where('subject_lesson_chapter', $this->lesson_id);
            })
            ->when($this->question_type, function ($q) {
                return $q->where('question_type', $this->question_type);
            })
            ->when($this->statusFilter, function ($q) {
                return $q->where('status', $this->statusFilter);
            });
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedRows = $this->filteredQuery()
                ->pluck('id')
                ->map(fn ($id) => (string) $id)
                ->toArray();
        } else {
            $this->selectedRows = [];
        }
    }

    public function render()
    {
        $questions = $this->filteredQuery()
            ->with(['educationType', 'classGroup', 'inSubject', 'inSubjectPart', 'inSubjectLesson'])
            ->latest()
            ->paginate(15);

        // Fetching related data for filters
        $this->educationTypes = Educationtype::all();
        $this->classes = $this->education_type_id ? ClassGoupExamModel::where('education_type_id', $this->education_type_id)->get() : [];

        $class = $this->class_id ? ClassGoupExamModel::find($this->class_id) : null;
        $this->subjects = $class ? $class->class_subjects()->get() : [];

        $this->parts = $this->subject_id ? SubjectPart::where('subject_id', $this->subject_id)->get() : [];
        $this->lessons = $this->part_id ? SubjectPartLesson::where('subject_part_id', $this->part_id)->get() : [];

        return view('livewire.admin.questions.question-table', [
            'questions' => $questions,
            'data' => ['pagename' => 'Question Bank'],
        ]);
    }
}
