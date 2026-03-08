<?php

namespace App\Livewire\Admin\Questions;

use App\Models\BoardAgencyStateModel;
use App\Models\ClassGoupExamModel;
use App\Models\Educationtype;
use App\Models\QuestionBankModel;
use App\Models\SubjectPart;
use App\Models\SubjectPartLesson;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class QuestionForm extends Component
{
    use WithFileUploads;

    #[Layout('Layouts.admin')]
    public $questionId = 0;

    public $question_type = 1; // 1: MCQ, 2: Subjective

    public $mcq_options_count = 4;

    public $mcq_answer = 1;

    public $education_type_id = '';

    public $class_id = '';

    public $board_id = '';

    public $subject_id = '';

    public $part_id = '';

    public $chapter_id = '';

    public $lesson_id = '';

    public $question_content = '';

    public $ans_1 = '';

    public $ans_2 = '';

    public $ans_3 = '';

    public $ans_4 = '';

    public $ans_5 = '';

    public $solution = '';

    public $explanation = '';

    public $difficulty_level = 50;

    public $status = 'pending';

    public $educationTypes = [];

    public $classes = [];

    public $boards = [];

    public $subjects = [];

    public $parts = [];

    public $chapters = [];

    public $lessons = [];

    protected $rules = [
        'education_type_id' => 'required',
        'class_id' => 'required',
        'question_type' => 'required',
        'question_content' => 'required',
        'difficulty_level' => 'required|numeric|min:0|max:100',
    ];

    public function mount($questionId = 0)
    {
        $this->questionId = $questionId;
        $this->educationTypes = Educationtype::all();

        if ($this->questionId > 0) {
            $question = QuestionBankModel::findOrFail($this->questionId);
            $this->loadQuestionData($question);
        }
    }

    private function loadQuestionData($question)
    {
        $this->education_type_id = $question->education_type_id;
        $this->classes = ClassGoupExamModel::where('education_type_id', $this->education_type_id)->get();

        $this->class_id = $question->class_group_exam_id;
        $class = ClassGoupExamModel::find($this->class_id);

        $agency_board_university = \App\Models\Gn_EducationClassExamAgencyBoardUniversity::where('classes_group_exams_id', $this->class_id)->pluck('board_agency_exam_id')->toArray();
        $this->boards = empty($agency_board_university) ? [] : BoardAgencyStateModel::whereIn('id', $agency_board_university)->get();

        $this->subjects = \App\Models\Subject::select('subjects.*')
            ->leftJoin('gn__class_subjects', 'gn__class_subjects.subject_id', '=', 'subjects.id')
            ->where('gn__class_subjects.classes_group_exams_id', $this->class_id)
            ->get();

        $this->board_id = $question->board_agency_state_id;
        $this->subject_id = $question->subject;

        if ($this->subject_id) {
            $this->parts = SubjectPart::where('subject_id', $this->subject_id)->get();
        }

        $this->part_id = $question->subject_part;
        if ($this->part_id) {
            $this->chapters = SubjectPartLesson::where('subject_part_id', $this->part_id)->get();
        }

        // Determine if subject_lesson_chapter holds a Chapter (level 3) or Lesson (level 4)
        $savedValue = $question->subject_lesson_chapter;
        if ($savedValue) {
            $isLesson = \App\Models\Gn_SubjectPartLessionNew::find($savedValue);
            if ($isLesson) {
                // It's a Level 4 lesson
                $this->chapter_id = $isLesson->subject_chapter_id;
                $this->lessons = \App\Models\Gn_SubjectPartLessionNew::where('subject_chapter_id', $this->chapter_id)->get();
                $this->lesson_id = $savedValue;
            } else {
                // It's a Level 3 chapter
                $this->chapter_id = $savedValue;
                $this->lessons = \App\Models\Gn_SubjectPartLessionNew::where('subject_chapter_id', $this->chapter_id)->get();
            }
        }
        $this->question_type = $question->question_type;
        $this->mcq_options_count = (int) ($question->mcq_options ?? 4);
        $this->mcq_answer = (int) (str_replace('ans_', '', $question->mcq_answer) ?: 1);

        $this->question_content = $question->question;
        $this->ans_1 = $question->ans_1;
        $this->ans_2 = $question->ans_2;
        $this->ans_3 = $question->ans_3;
        $this->ans_4 = $question->ans_4;
        $this->ans_5 = $question->ans_5;
        $this->solution = $question->solution;
        $this->explanation = $question->explanation;
        $this->difficulty_level = $question->difficulty_level ?? 0;
        $this->status = $question->status ?? 'pending';
    }

    public function updatedEducationTypeId($value)
    {
        $this->classes = $value ? ClassGoupExamModel::where('education_type_id', $value)->get() : [];
        $this->reset(['class_id', 'board_id', 'subject_id', 'part_id', 'chapter_id', 'lesson_id', 'boards', 'subjects', 'parts', 'chapters', 'lessons']);
    }

    public function updatedClassId($value)
    {
        $class = $value ? ClassGoupExamModel::find($value) : null;
        $agency_board_university = \App\Models\Gn_EducationClassExamAgencyBoardUniversity::where('classes_group_exams_id', $value)->pluck('board_agency_exam_id')->toArray();
        $this->boards = empty($agency_board_university) ? [] : BoardAgencyStateModel::whereIn('id', $agency_board_university)->get();
        $this->subjects = $class ? \App\Models\Subject::select('subjects.*')
            ->leftJoin('gn__class_subjects', 'gn__class_subjects.subject_id', '=', 'subjects.id')
            ->where('gn__class_subjects.classes_group_exams_id', $value)
            ->get() : [];
        $this->reset(['board_id', 'subject_id', 'part_id', 'chapter_id', 'lesson_id', 'parts', 'chapters', 'lessons']);
    }

    public function updatedSubjectId($value)
    {
        $this->parts = $value ? SubjectPart::where('subject_id', $value)->get() : [];
        $this->reset(['part_id', 'chapter_id', 'lesson_id', 'chapters', 'lessons']);
    }

    public function updatedPartId($value)
    {
        $this->chapters = $value ? SubjectPartLesson::where('subject_part_id', $value)->get() : [];
        $this->reset(['chapter_id', 'lesson_id', 'lessons']);
    }

    public function updatedChapterId($value)
    {
        $this->lessons = $value ? \App\Models\Gn_SubjectPartLessionNew::where('subject_chapter_id', $value)->get() : [];
        $this->reset(['lesson_id']);
    }

    public function updatedMcqOptionsCount($value)
    {
        $this->dispatch('mcq-updated');
    }

    public function save()
    {
        $this->validate();

        $data = [
            'education_type_id' => $this->education_type_id,
            'class_group_exam_id' => $this->class_id,
            'board_agency_state_id' => $this->board_id,
            'subject' => $this->subject_id,
            'subject_part' => $this->part_id,
            'subject_lesson_chapter' => $this->lesson_id ?: $this->chapter_id,
            'question_type' => $this->question_type,
            'question' => $this->question_content,
            'difficulty_level' => $this->difficulty_level,
            'solution' => $this->solution,
            'explanation' => $this->explanation,
            'status' => $this->status,
        ];

        if ($this->question_type == 1) {
            $data['mcq_options'] = (int) $this->mcq_options_count;
            $data['mcq_answer'] = 'ans_'.$this->mcq_answer;
            $data['ans_1'] = $this->ans_1;
            $data['ans_2'] = $this->ans_2;
            $data['ans_3'] = $this->ans_3;
            $data['ans_4'] = $this->ans_4;
            $data['ans_5'] = $this->ans_5;
        } else {
            // Clear MCQ data for subjective
            $data['mcq_options'] = null;
            $data['mcq_answer'] = null;
            $data['ans_1'] = null;
            $data['ans_2'] = null;
            $data['ans_3'] = null;
            $data['ans_4'] = null;
            $data['ans_5'] = null;
        }

        if ($this->questionId > 0) {
            QuestionBankModel::find($this->questionId)->update($data);
            $this->dispatch('notify', ['type' => 'success', 'message' => 'Question updated successfully.']);
        } else {
            $data['creator_id'] = Auth::id();
            QuestionBankModel::create($data);
            session()->flash('success', 'Question created successfully.');

            return redirect()->route('administrator.dashboard_question_list');
        }
    }

    public function render()
    {
        return view('livewire.admin.questions.question-form', [
            'data' => ['pagename' => $this->questionId > 0 ? 'Update Question' : 'Add Question'],
        ]);
    }
}
