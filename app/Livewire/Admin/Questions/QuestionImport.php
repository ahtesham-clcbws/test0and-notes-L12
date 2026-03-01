<?php

namespace App\Livewire\Admin\Questions;

use App\Imports\QuestionBankImport;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

#[Layout('Layouts.admin')]
class QuestionImport extends Component
{
    use WithFileUploads;

    public $education_type_id = '';
    public $class_id = '';
    public $board_id = '';
    public $subject_id = '';
    public $part_id = '';
    public $lesson_id = '';
    public $question_type = 1;

    public $educationTypes = [];
    public $classes = [];
    public $boards = [];
    public $subjects = [];
    public $parts = [];
    public $lessons = [];

    public $file;

    public $isImporting = false;
    public $showPreview = false;
    public $previewData = [];

    public function mount()
    {
        $this->educationTypes = \App\Models\Educationtype::all();
    }

    public function updatedEducationTypeId($value)
    {
        $this->classes = $value ? \App\Models\ClassGoupExamModel::where('education_type_id', $value)->get() : [];
        $this->reset(['class_id', 'board_id', 'subject_id', 'part_id', 'lesson_id', 'boards', 'subjects', 'parts', 'lessons']);
    }

    public function updatedClassId($value)
    {
        $this->boards = $value ? \App\Models\BoardAgencyStateModel::where('classes_group_exams_id', $value)->get() : [];
        $class = $value ? \App\Models\ClassGoupExamModel::find($value) : null;
        $this->subjects = $class ? $class->class_subjects()->get() : [];
        $this->reset(['board_id', 'subject_id', 'part_id', 'lesson_id', 'parts', 'lessons']);
    }

    public function updatedSubjectId($value)
    {
        $this->parts = $value ? \App\Models\SubjectPart::where('subject_id', $value)->get() : [];
        $this->reset(['part_id', 'lesson_id', 'lessons']);
    }

    public function updatedPartId($value)
    {
        $this->lessons = $value ? \App\Models\SubjectPartLesson::where('subject_part_id', $value)->get() : [];
        $this->reset(['lesson_id']);
    }

    public function import()
    {
        $this->validate([
            'education_type_id' => 'required',
            'class_id' => 'required',
            'subject_id' => 'required',
            'question_type' => 'required',
            'file' => 'required|mimes:xlsx,xls,csv|max:10240', // 10MB max
        ]);

        $this->isImporting = true;

        try {
            $importData = [
                'education_type_id' => $this->education_type_id,
                'class_group_exam_id' => $this->class_id,
                'board_agency_state_id' => $this->board_id,
                'subject' => $this->subject_id,
                'subject_part' => $this->part_id,
                'subject_lesson_chapter' => $this->lesson_id,
                'question_type' => $this->question_type,
            ];

            $importAction = new QuestionBankImport($this->file->getRealPath(), $importData);
            Excel::import($importAction, $this->file->getRealPath());

            $this->previewData = $importAction->parsedData;
            $this->showPreview = true;

            $this->dispatch('notify', ['type' => 'success', 'message' => 'File parsed successfully. Please review the records.']);

        } catch (\Exception $e) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Structural failure during parsing: '.$e->getMessage()]);
        } finally {
            $this->isImporting = false;
        }
    }

    public function saveAll()
    {
        $this->isImporting = true;
        try {
            foreach ($this->previewData as $data) {
                \App\Models\QuestionBankModel::create($data);
            }
            session()->flash('success', 'Questions successfully integrated into architectural bank.');
            return redirect()->route('administrator.dashboard_question_list');
        } catch (\Exception $e) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Failed to save to database: '.$e->getMessage()]);
        } finally {
            $this->isImporting = false;
        }
    }

    public function cancelPreview()
    {
        $this->showPreview = false;
        $this->previewData = [];
        $this->reset('file');
    }

    public function render()
    {
        return view('livewire.admin.questions.question-import', [
            'data' => ['pagename' => 'Import Questions'],
        ]);
    }
}
