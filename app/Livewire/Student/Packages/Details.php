<?php

namespace App\Livewire\Student\Packages;

use App\Models\Gn_PackagePlan;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.student-mary')]
class Details extends Component
{
    public $packageId;

    public $package_plan;

    public $test = [];

    public $study_material = [];

    public $live_video = [];

    public $onegk = [];

    public function mount($id)
    {
        $this->packageId = $id;
        $this->loadPackageData();
    }

    public function loadPackageData()
    {
        $this->package_plan = Gn_PackagePlan::with(['educationType', 'classType'])->find($this->packageId);

        if (! $this->package_plan) {
            return redirect()->route('student.dashboard');
        }

        // Purchase Verification (Replicated from legacy ExamsController@package_manage)
        if ($this->package_plan->final_fees > 0) {
            $has_purchased = \App\Models\Gn_PackageTransaction::where('student_id', \Illuminate\Support\Facades\Auth::id())
                ->where('plan_id', $this->packageId)
                ->whereIn('plan_status', [1, 2])
                ->exists();

            if (! $has_purchased) {
                return redirect()->route('student.plan')->with('error', 'You need to purchase this package to view it.');
            }
        }

        // Replicate logic from ExamsController@package_manage
        $test_ids = $this->package_plan->test()->pluck('test_id')->toArray();

        // Load Study Materials (Notes)
        if ($this->package_plan->study_material_id) {
            $ids = array_filter(array_map('intval', explode(',', $this->package_plan->study_material_id)));
            $this->study_material = DB::table('study_material')
                ->leftJoin('classes_groups_exams', 'study_material.class', 'classes_groups_exams.id')
                ->select('study_material.*', 'classes_groups_exams.name')
                ->whereIn('study_material.id', $ids)
                ->get();
        }

        // Load Videos
        if ($this->package_plan->video_id) {
            $ids = array_filter(array_map('intval', explode(',', $this->package_plan->video_id)));
            $this->live_video = DB::table('study_material')
                ->leftJoin('classes_groups_exams', 'study_material.class', 'classes_groups_exams.id')
                ->select('study_material.*', 'classes_groups_exams.name')
                ->whereIn('study_material.id', $ids)
                ->get();
        }

        // Load GK
        if ($this->package_plan->static_gk_id) {
            $ids = array_filter(array_map('intval', explode(',', $this->package_plan->static_gk_id)));
            $this->onegk = DB::table('study_material')
                ->leftJoin('classes_groups_exams', 'study_material.class', 'classes_groups_exams.id')
                ->select('study_material.*', 'classes_groups_exams.name')
                ->whereIn('study_material.id', $ids)
                ->get();
        }

        // Load Tests
        if (! empty($test_ids)) {
            $this->test = DB::table('test')
                ->leftJoin('classes_groups_exams', 'test.education_type_child_id', 'classes_groups_exams.id')
                ->select('test.*', 'classes_groups_exams.name as class_name')
                ->whereIn('test.id', $test_ids)
                ->whereNull('test.deleted_at')
                ->where('test.published', 1)
                ->get();
        }
    }

    public function render()
    {
        return view('livewire.student.packages.details');
    }
}
