<?php

namespace App\Livewire\Admin\Questions;

use App\Imports\QuestionBankImport;
use App\Models\QuestionBankModel;
use Illuminate\Support\Facades\Auth;
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

    public $chapter_id = '';

    public $lesson_id = '';

    public $question_type = 1;

    public $educationTypes = [];

    public $classes = [];

    public $boards = [];

    public $subjects = [];

    public $parts = [];

    public $chapters = [];

    public $lessons = [];

    public $file;

    public $importMode = 'file'; // 'file' or 'paste'

    public $pastedText = '';

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
        $this->reset(['class_id', 'board_id', 'subject_id', 'part_id', 'chapter_id', 'lesson_id', 'boards', 'subjects', 'parts', 'chapters', 'lessons']);
    }

    public function updatedClassId($value)
    {
        $class = $value ? \App\Models\ClassGoupExamModel::find($value) : null;
        $agency_board_university = \App\Models\Gn_EducationClassExamAgencyBoardUniversity::where('classes_group_exams_id', $value)->pluck('board_agency_exam_id')->toArray();
        $this->boards = empty($agency_board_university) ? [] : \App\Models\BoardAgencyStateModel::whereIn('id', $agency_board_university)->get();
        $this->subjects = $class ? \App\Models\Subject::select('subjects.*')
            ->leftJoin('gn__class_subjects', 'gn__class_subjects.subject_id', '=', 'subjects.id')
            ->where('gn__class_subjects.classes_group_exams_id', $value)
            ->get() : [];
        $this->reset(['board_id', 'subject_id', 'part_id', 'chapter_id', 'lesson_id', 'parts', 'chapters', 'lessons']);
    }

    public function updatedSubjectId($value)
    {
        $this->parts = $value ? \App\Models\SubjectPart::where('subject_id', $value)->get() : [];
        $this->reset(['part_id', 'chapter_id', 'lesson_id', 'chapters', 'lessons']);
    }

    public function updatedPartId($value)
    {
        $this->chapters = $value ? \App\Models\SubjectPartLesson::where('subject_part_id', $value)->get() : [];
        $this->reset(['chapter_id', 'lesson_id', 'lessons']);
    }

    public function updatedChapterId($value)
    {
        $this->lessons = $value ? \App\Models\Gn_SubjectPartLessionNew::where('subject_chapter_id', $value)->get() : [];
        $this->reset(['lesson_id']);
    }

    public function insertSampleFormat(): void
    {
        $this->pastedText = "1. What is the capital of France?\nA) London\nB) Berlin\nC) Paris\nD) Madrid\nCorrect Answer: (C)\nExplanation: Paris has been the capital since 508 AD.\n\n2. What is the powerhouse of the cell?\nA) Nucleus\nB) Ribosome\nC) Mitochondria\nD) Endoplasmic Reticulum\nAnswer: C\n\n3. Which planet is known as the Red Planet?\nA) Earth\nB) Mars\nC) Jupiter\nD) Saturn\nAns: B";
    }

    public function parsePastedText(): void
    {
        $this->validate([
            'education_type_id' => 'required',
            'class_id' => 'required',
            'subject_id' => 'required',
            'question_type' => 'required',
            'pastedText' => 'required|string|min:10',
        ], [
            'education_type_id.required' => 'Please select an Education Type.',
            'class_id.required' => 'Please select a Class / Group.',
            'subject_id.required' => 'Please select a Subject.',
            'pastedText.required' => 'Please paste formatted MCQ text.',
            'pastedText.min' => 'Pasted text is too short to contain valid questions.',
        ]);

        $this->isImporting = true;

        try {
            $parsed = $this->parseFormattedMcqText($this->pastedText);

            if (empty($parsed)) {
                $this->dispatch('notify', ['type' => 'error', 'message' => 'No valid questions could be extracted. Please check the format.']);

                return;
            }

            $this->previewData = $parsed;
            $this->showPreview = true;

            $this->dispatch('notify', ['type' => 'success', 'message' => count($parsed).' questions parsed successfully. Please review below.']);
        } catch (\Exception $e) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Parsing error: '.$e->getMessage()]);
        } finally {
            $this->isImporting = false;
        }
    }

    public function parseFormattedMcqText(string $pastedData): array
    {
        $pastedData = html_entity_decode($pastedData, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $questions = [];
        $current = [];
        $answers = [];
        $lines = preg_split('/\r?\n+/', trim($pastedData));

        $finalize = function (&$cur, &$ans, &$qList) {
            if (! empty($cur['question'])) {
                $cur['ans_1'] = $ans[0] ?? null;
                $cur['ans_2'] = $ans[1] ?? null;
                $cur['ans_3'] = $ans[2] ?? null;
                $cur['ans_4'] = $ans[3] ?? null;
                $cur['ans_5'] = $ans[4] ?? null;
                $cur['mcq_options'] = count($ans) > 4 ? 5 : 4;
                if (empty($cur['mcq_answer'])) {
                    $cur['mcq_answer'] = 'ans_1';
                }
                $qList[] = $cur;
            }
        };

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }

            if (preg_match('/^(?:Q(?:uestion)?\.?\s*)?\d+[\.\)]\s*(.+)/i', $line, $matches)) {
                $finalize($current, $answers, $questions);
                $current = [
                    'question' => trim($matches[1]),
                    'solution' => null,
                    'explanation' => null,
                    'question_type' => (int) $this->question_type,
                    'status' => 'approved',
                ];
                $answers = [];
            } elseif (preg_match('/^(?:\(?([A-Ea-e])\)|([A-Ea-e])[\.\)])\s*(.+)/', $line, $matches)) {
                $letter = strtoupper(! empty($matches[1]) ? $matches[1] : $matches[2]);
                $optText = trim($matches[3]);
                $idx = ord($letter) - ord('A');
                $answers[$idx] = $optText;
            } elseif (preg_match('/^(?:Correct\s+)?Ans(?:wer)?\s*[:\-]?\s*\(?([A-Ea-e]|ans_[1-5])\)?/i', $line, $matches)) {
                $val = $matches[1];
                if (str_starts_with(strtolower($val), 'ans_')) {
                    $current['mcq_answer'] = strtolower($val);
                } else {
                    $idx = ord(strtoupper($val)) - ord('A') + 1;
                    $current['mcq_answer'] = 'ans_'.$idx;
                }
            } elseif (preg_match('/^(?:Explanation|Solution|Exp)\s*[:\-]\s*(.+)/i', $line, $matches)) {
                $current['explanation'] = trim($matches[1]);
                $current['solution'] = trim($matches[1]);
            } elseif (isset($current['question']) && empty($answers)) {
                $current['question'] .= "\n".$line;
            } elseif (! empty($current['explanation'])) {
                $current['explanation'] .= "\n".$line;
                $current['solution'] .= "\n".$line;
            }
        }

        $finalize($current, $answers, $questions);

        return $questions;
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
                'subject_lesson_chapter' => $this->lesson_id ?: $this->chapter_id,
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
                // Ensure categorization and status are correctly set
                $data['education_type_id'] = $this->education_type_id ?: null;
                $data['class_group_exam_id'] = $this->class_id ?: null;
                $data['board_agency_state_id'] = $this->board_id ?: null;
                $data['subject'] = $this->subject_id ?: null;
                $data['subject_part'] = $this->part_id ?: null;
                $data['subject_lesson_chapter'] = $this->lesson_id ?: ($this->chapter_id ?: null);
                $data['status'] = 'approved';
                $data['creator_id'] = Auth::id();

                QuestionBankModel::create($data);
            }
            session()->flash('success', 'Questions successfully integrated into system bank.');

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
