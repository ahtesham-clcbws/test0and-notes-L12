<?php

namespace App\Livewire\Admin\Tests;

use App\Models\Gn_PackagePlan;
use App\Models\Gn_PackagePlanTest;
use App\Models\TestCat;
use App\Models\TestModal;
use Livewire\Attributes\Layout;
use Livewire\Component;

class PublishTest extends Component
{
    public $testId;

    public $test;

    // Test specific fields mapped from DB
    public $show_result = false;

    public $show_answer = false;

    public $show_solution = false;

    public $show_rank = false;

    public $test_type = 1; // 1 = Free, 0 = Paid

    public $test_cat;

    public $price = 0;

    // Package selection
    public $selectedPackages = [];

    // Form data sources
    public $categories = [];

    public $availablePackages = [];

    public function mount($test_id)
    {
        $this->testId = $test_id;
        $this->test = TestModal::with(['Educationtype', 'EducationClass', 'EducationBoard', 'OtherCategoryClass'])->findOrFail($test_id);

        // Bind existing data
        $this->show_result = (bool) $this->test->show_result;
        $this->show_answer = (bool) $this->test->show_answer;
        $this->show_solution = (bool) $this->test->show_solution;
        $this->show_rank = (bool) $this->test->show_rank;
        $this->test_type = $this->test->test_type ?? 1;
        $this->test_cat = $this->test->test_cat;
        $this->price = $this->test->price ?? 0;

        // Load Categories
        $this->categories = TestCat::all();

        // Load existing packages
        $this->selectedPackages = Gn_PackagePlanTest::where('test_id', $this->testId)
            ->pluck('gn_package_plan_id')
            ->toArray();

        $this->loadPackages();
    }

    public function updatedTestType()
    {
        $this->loadPackages();
    }

    private function loadPackages()
    {
        if ($this->test) {
            $query = Gn_PackagePlan::where('education_type', $this->test->education_type_id)
                ->where('class', $this->test->education_type_child_id)
                ->where('package_category', $this->test_type);
            
            $available = $query->get();

            // Always ensure currently selected packages are shown, even if they no longer match the criteria
            if (!empty($this->selectedPackages)) {
                $selected = Gn_PackagePlan::whereIn('id', $this->selectedPackages)->get();
                $this->availablePackages = $available->merge($selected)->unique('id');
            } else {
                $this->availablePackages = $available;
            }
        }
    }

    public function save()
    {
        $this->validate([
            'test_type' => 'required',
            'test_cat' => 'required',
            'price' => 'required_if:test_type,0',
        ]);

        $this->test->update([
            'show_result' => $this->show_result,
            'show_answer' => $this->show_answer,
            'show_solution' => $this->show_solution,
            'show_rank' => $this->show_rank,
            'test_type' => $this->test_type,
            'test_cat' => $this->test_cat,
            'price' => $this->test_type == 1 ? null : $this->price,
            'published' => 1,
            'package' => ! empty($this->selectedPackages) ? implode(',', $this->selectedPackages) : null,
        ]);

        // Sync Packages
        Gn_PackagePlanTest::where('test_id', $this->test->id)->delete();
        if (! empty($this->selectedPackages)) {
            foreach ($this->selectedPackages as $packageId) {
                Gn_PackagePlanTest::create([
                    'gn_package_plan_id' => $packageId,
                    'test_id' => $this->test->id,
                ]);
            }
        }

        session()->flash('message', 'Test published successfully.');

        return redirect()->route('administrator.dashboard_tests_list');
    }

    #[Layout('Layouts.admin')]
    public function render()
    {
        return view('livewire.admin.tests.publish-test');
    }
}
