<?php

namespace App\Livewire\Admin\Tests;

use App\Models\Gn_SubjectPartLessionNew;
use App\Models\SubjectPart;
use App\Models\SubjectPartLesson;
use App\Models\TestSections;
use Livewire\Component;

class TestSectionRow extends Component
{
    public $sectionId;

    public $testId;

    public $index;

    public $subject_id;

    public $part_id;

    public $chapter_id;

    public $lesson_id;

    public $number_of_questions;

    public $question_type = 1;

    public $mcq_options = 4;

    public $difficulty_level = 50;

    public $creator_id;

    public $date_of_completion;

    public $duration = 1;

    public $publisher_id;

    public $publishing_date;

    public $section_instruction;

    protected $listeners = ['saveSection' => 'save'];

    public $subjects = [];

    public $parts = [];

    public $chapters = [];

    public $lessons = [];

    public $creators = [];

    public $publishers = [];

    protected $rules = [
        'subject_id' => 'required',
        'number_of_questions' => 'required|numeric|min:1',
        'question_type' => 'required',
        'difficulty_level' => 'required|numeric|min:0|max:100',
    ];

    public function mount($index, $testId, $sectionId = 0, $subjects = [], $creators = [], $publishers = [])
    {
        $this->index = $index;
        $this->testId = $testId;
        $this->sectionId = $sectionId;
        $this->subjects = $subjects;
        $this->creators = $creators;
        $this->publishers = $publishers;

        if ($this->sectionId > 0) {
            $section = TestSections::find($this->sectionId);
            $this->loadSectionData($section);
        }
    }

    private function loadSectionData($section)
    {
        $this->subject_id = $section->subject;
        if ($this->subject_id) {
            $this->updatedSubjectId($this->subject_id);
        }

        $this->part_id = $section->subject_part;
        if ($this->part_id) {
            $this->updatedPartId($this->part_id);
        }

        $this->chapter_id = $section->subject_part_lesson;
        if ($this->chapter_id) {
            $this->updatedChapterId($this->chapter_id);
        }

        $this->lesson_id = $section->gn_subject_part_lesson;
        $this->number_of_questions = $section->number_of_questions;

        // Automation: If this is the only section and no questions are set, pull from test
        if (empty($this->number_of_questions) || $this->number_of_questions == 0) {
            $test = \App\Models\TestModal::find($this->testId);
            if ($test && $test->sections == 1) {
                $this->number_of_questions = $test->total_questions;
            }
        }

        $this->question_type = $section->question_type ?? 1;
        $this->mcq_options = $section->mcq_options ?? 4;
        $this->difficulty_level = $section->difficulty_level;
        $this->creator_id = $section->creator_id;
        $this->date_of_completion = $section->date_of_completion;
        $this->duration = $section->duration;
        $this->publisher_id = $section->publisher_id;
        $this->publishing_date = $section->publishing_date;
        $this->section_instruction = $section->section_instruction;
    }

    public function updatedSubjectId($value)
    {
        $this->parts = SubjectPart::where('subject_id', $value)->get();
        $this->part_id = '';
        $this->chapters = [];
        $this->lessons = [];
    }

    public function updatedPartId($value)
    {
        $this->chapters = SubjectPartLesson::where('subject_part_id', $value)->get();
        $this->chapter_id = '';
        $this->lessons = [];
    }

    public function updatedChapterId($value)
    {
        // Use Gn_SubjectPartLessionNew for the fourth level (Lesson)
        $this->lessons = Gn_SubjectPartLessionNew::where([
            'subject_id' => $this->subject_id,
            'subject_part_id' => $this->part_id,
            'subject_chapter_id' => $value,
        ])->get();
        $this->lesson_id = '';
    }

    public function save()
    {
        $this->validate();

        $data = [
            'test_id' => $this->testId,
            'subject' => $this->subject_id,
            'subject_part' => $this->part_id ?: 0,
            'subject_part_lesson' => $this->chapter_id ?: 0,
            'gn_subject_part_lesson' => $this->lesson_id ?: 0,
            'number_of_questions' => $this->number_of_questions,
            'question_type' => $this->question_type,
            'mcq_options' => ($this->question_type == 1) ? $this->mcq_options : 0,
            'difficulty_level' => $this->difficulty_level,
            'creator_id' => $this->creator_id,
            'date_of_completion' => $this->date_of_completion,
            'duration' => $this->duration,
            'publisher_id' => $this->publisher_id,
            'publishing_date' => $this->publishing_date,
            'section_instruction' => $this->section_instruction,
        ];

        try {
            if ($this->sectionId > 0) {
                TestSections::find($this->sectionId)->update($data);
            } else {
                $section = TestSections::create($data);
                $this->sectionId = $section->id;
            }
            $this->dispatch('notify', type: 'success', message: 'Section saved successfully.');
        } catch (\Exception $e) {
            $this->dispatch('notify', type: 'error', message: 'Error saving section: '.$e->getMessage());
        }

        $this->dispatch('sectionSaved', index: $this->index);
    }

    public function remove()
    {
        if ($this->sectionId > 0) {
            TestSections::find($this->sectionId)->delete();
        }
        $this->dispatch('sectionRemoved', ['index' => $this->index]);
    }

    public function render()
    {
        return view('livewire.admin.tests.test-section-row');
    }
}
