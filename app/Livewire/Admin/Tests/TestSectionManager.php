<?php

namespace App\Livewire\Admin\Tests;

use App\Models\Gn_ClassSubject;
use App\Models\TestModal;
use App\Models\TestSections;
use App\Models\User;
use Livewire\Component;

class TestSectionManager extends Component
{
    public $testId;

    public $test;

    public $sectionKeys = []; // Array of [id, key] where key is a unique identifier (like timestamp)

    public $allSubjects = [];

    public $allCreators = [];

    public $allPublishers = [];

    protected $listeners = [
        'sectionRemoved' => 'removeSectionByKey',
        'sectionSaved' => 'handleSectionSaved',
    ];

    public function mount($testId)
    {
        $this->testId = $testId;
        $this->test = TestModal::findOrFail($testId);

        $this->allSubjects = Gn_ClassSubject::where('classes_group_exams_id', $this->test->education_type_child_id)
            ->with('subject')
            ->get()
            ->pluck('subject');

        $matchThis = ['in_franchise' => '0', 'isAdminAllowed' => '1'];
        $this->allCreators = User::where($matchThis)
            ->where(function ($q) {
                $q->where('roles', 'like', '%"creator"%')
                    ->orWhere('roles', 'like', '%"manager"%')
                    ->orWhere('roles', 'superadmin');
            })->get();

        $this->allPublishers = User::where($matchThis)
            ->where(function ($q) {
                $q->where('roles', 'like', '%"publisher"%')
                    ->orWhere('roles', 'superadmin');
            })->get();

        $this->loadSections();
    }

    public function loadSections()
    {
        $existingSections = TestSections::where('test_id', $this->testId)
            ->orderBy('id', 'asc')
            ->get();

        foreach ($existingSections as $section) {
            $this->sectionKeys[] = [
                'id' => $section->id,
                'key' => 'existing_'.$section->id,
            ];
        }

        if (empty($this->sectionKeys)) {
            $this->addSection();
        }
    }

    public function addSection()
    {
        // Manual adding is no longer needed as per user request.
        // Sections are dictated by TestForm.
    }

    public function removeSectionByKey($data)
    {
        // Manual removal is no longer needed as per user request.
    }

    public function handleSectionSaved($data)
    {
        // Optional: Show a global success notification
    }

    public function saveAll()
    {
        $this->dispatch('saveSection')->to(TestSectionRow::class);
    }

    public function render()
    {
        return view('livewire.admin.tests.test-section-manager');
    }
}
