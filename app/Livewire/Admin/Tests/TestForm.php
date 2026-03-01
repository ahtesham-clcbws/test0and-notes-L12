<?php

namespace App\Livewire\Admin\Tests;

use App\Models\ClassGoupExamModel;
use App\Models\Educationtype;
use App\Models\Gn_EducationClassExamAgencyBoardUniversity;
use App\Models\Gn_OtherExamClassDetailModel;
use App\Models\Gn_PackagePlan;
use App\Models\Gn_PackagePlanTest;
use App\Models\TestModal;
use App\Models\TestSections;
use App\Services\ImageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class TestForm extends Component
{
    use WithFileUploads;

    public $testId;

    public $title;

    public $sub_title;

    public $education_type_id;

    public $class_group_exam_id;

    public $exam_agency_board_university_id;

    public $other_exam_class_detail_id;

    public $marks_per_questions;

    public $negative_marks = 0;

    public $no_of_sections;

    public $total_questions;

    public $special_remark_1;

    public $special_remark_2;

    public $rating = 4.5;

    public $test_image;

    public $existing_image;

    public $test_type = 1;

    public $price;

    // Package integration
    public $selectedPackages = [];

    // Dropdown data
    public $educations = [];

    public $classes = [];

    public $agencies = [];

    public $otherExams = [];

    public $packages = [];

    // Constants
    public $marksOptions = [1, 2, 3, 4];

    public $negativeMarksOptions = [
        ['id' => '0', 'name' => 'No Negative Marking'],
        ['id' => '0.25', 'name' => '-0.25%'],
        ['id' => '0.33', 'name' => '-0.33%'],
        ['id' => '0.5', 'name' => '-0.50%'],
    ];

    public function mount($testId = null)
    {
        $this->educations = Educationtype::all();

        if ($testId) {
            $test = TestModal::findOrFail($testId);
            $this->testId = $test->id;
            $this->title = $test->title;
            $this->sub_title = $test->sub_title;
            $this->education_type_id = $test->education_type_id;
            $this->class_group_exam_id = $test->education_type_child_id;
            $this->exam_agency_board_university_id = $test->board_state_agency;
            $this->other_exam_class_detail_id = $test->other_category_class_id;
            $this->marks_per_questions = $test->gn_marks_per_questions;
            $this->negative_marks = $test->negative_marks;
            $this->no_of_sections = $test->sections;
            $this->total_questions = $test->total_questions;
            $this->special_remark_1 = $test->special_remark_1;
            $this->special_remark_2 = $test->special_remark_2;
            $this->rating = $test->rating;
            $this->existing_image = $test->test_image;
            $this->test_type = $test->test_type ?? 1;
            $this->price = $test->price;

            $this->selectedPackages = Gn_PackagePlanTest::where('test_id', $this->testId)
                ->pluck('gn_package_plan_id')
                ->toArray();

            $this->loadClasses($this->education_type_id);
            $this->loadAgenciesAndPackages($this->class_group_exam_id);
            $this->loadOtherExams($this->exam_agency_board_university_id);
        }
    }

    private function loadClasses($educationTypeId)
    {
        $this->classes = ClassGoupExamModel::where('education_type_id', $educationTypeId)->get();
    }

    private function loadAgenciesAndPackages($classId)
    {
        $this->agencies = Gn_EducationClassExamAgencyBoardUniversity::where('education_type_id', $this->education_type_id)
            ->where('classes_group_exams_id', $classId)
            ->with('agencyBoardUniversity')
            ->get();

        // The legacy InternalRequestsController uses $request->input('test_type') directly
        // to filter package_category. 1 = Free, 0 = Paid.
        $this->packages = Gn_PackagePlan::where('education_type', $this->education_type_id)
            ->where('class', $classId)
            ->where('package_category', $this->test_type)
            ->get();

        \Illuminate\Support\Facades\Log::info('Loading packages for class: '.$classId.' Category: '.$this->test_type.' Found: '.count($this->packages));
    }

    private function loadOtherExams($agencyId)
    {
        $this->otherExams = Gn_OtherExamClassDetailModel::where('education_type_id', $this->education_type_id)
            ->where('classes_group_exams_id', $this->class_group_exam_id)
            ->where('agency_board_university_id', $agencyId)
            ->get();
    }

    public function updatedEducationTypeId($value)
    {
        $this->loadClasses($value);
        $this->class_group_exam_id = null;
        $this->agencies = [];
        $this->packages = [];
        $this->otherExams = [];
    }

    public function updatedClassGroupExamId($value)
    {
        $this->loadAgenciesAndPackages($value);
        $this->exam_agency_board_university_id = null;
        $this->otherExams = [];
    }

    public function updatedTestType($value)
    {
        $this->loadAgenciesAndPackages($this->class_group_exam_id);
    }

    public function updatedExamAgencyBoardUniversityId($value)
    {
        $this->loadOtherExams($value);
        $this->other_exam_class_detail_id = null;
    }

    public function save()
    {
        $this->validate([
            'title' => 'required',
            'education_type_id' => 'required',
            'class_group_exam_id' => 'required',
            'exam_agency_board_university_id' => 'required',
            'other_exam_class_detail_id' => 'required',
            'marks_per_questions' => 'required',
            'no_of_sections' => 'required|integer|min:1|max:10',
            'total_questions' => 'required|integer|min:1',
            'test_image' => 'nullable|image|max:1024',
        ]);

        DB::beginTransaction();
        try {
            $test = $this->testId ? TestModal::find($this->testId) : new TestModal;

            $test->title = $this->title;
            $test->sub_title = $this->sub_title;
            $test->education_type_id = $this->education_type_id;
            $test->education_type_child_id = $this->class_group_exam_id;
            $test->board_state_agency = $this->exam_agency_board_university_id;
            $test->other_category_class_id = $this->other_exam_class_detail_id;
            $test->gn_marks_per_questions = $this->marks_per_questions;
            $test->negative_marks = $this->negative_marks;
            $test->sections = $this->no_of_sections;
            $test->total_questions = $this->total_questions;
            $test->special_remark_1 = $this->special_remark_1;
            $test->special_remark_2 = $this->special_remark_2;
            $test->rating = $this->rating;
            $test->user_id = Auth::id();
            $test->test_type = $this->test_type;
            $test->price = $this->price;
            $test->package = ! empty($this->selectedPackages) ? implode(',', $this->selectedPackages) : null;

            if ($this->test_image) {
                $test->test_image = app(ImageService::class)->handleUpload($this->test_image, 'test_image', 800);
            }

            $test->save();
            $this->testId = $test->id;

            // Handle sections creation/deletion if count changed
            $existingSections = TestSections::where('test_id', $test->id)->orderBy('id')->get();
            $currentCount = $existingSections->count();

            if ($currentCount < $this->no_of_sections) {
                // Add missing sections
                for ($i = $currentCount; $i < $this->no_of_sections; $i++) {
                    TestSections::create([
                        'test_id' => $test->id,
                        'section_index' => $i + 1,
                    ]);
                }
            } elseif ($currentCount > $this->no_of_sections) {
                // Remove extra sections from the end
                $toDelete = $existingSections->slice($this->no_of_sections);
                foreach ($toDelete as $sec) {
                    $sec->delete();
                }
            }

            // Sync Packages
            Gn_PackagePlanTest::where('test_id', $test->id)->delete();
            if (! empty($this->selectedPackages)) {
                foreach ($this->selectedPackages as $packageId) {
                    Gn_PackagePlanTest::create([
                        'gn_package_plan_id' => $packageId,
                        'test_id' => $test->id,
                    ]);
                }
            }

            DB::commit();
            session()->flash('message', 'Test saved successfully.');

            return redirect()->route('administrator.dashboard_update_test_exam', $test->id);

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error saving test: '.$e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.tests.test-form');
    }
}
