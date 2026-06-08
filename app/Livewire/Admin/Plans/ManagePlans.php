<?php

namespace App\Livewire\Admin\Plans;

use App\Models\Gn_PackagePlan;
use App\Models\Studymaterial;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('Layouts.admin')]
class ManagePlans extends Component
{
    use WithFileUploads;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';

    public $sortBy = 'id';

    public $sortDirection = 'desc';

    // Modal details state
    public $showDetailsModal = false;

    public $selectedPlanName = '';

    public $selectedTests = [];

    public $selectedNotes = [];

    public $selectedVideos = [];

    public $selectedGK = [];

    public $extensionAmounts = []; // Array to bind selected extend values per plan [planId => amount]

    // Modal banner upload state
    public $showUploadModal = false;

    public $selectedPlanIdForBanner = null;

    public $bannerFile = null;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function sort($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function toggleFeatured($id)
    {
        $plan = Gn_PackagePlan::findOrFail($id);
        $plan->is_featured = ! $plan->is_featured;
        $plan->save();

        session()->flash('message', 'Featured status updated for plan: '.$plan->plan_name);
    }

    public function toggleMobile($id)
    {
        $plan = Gn_PackagePlan::findOrFail($id);
        $targetStatus = ! $plan->is_mobile;

        if ($targetStatus && (empty($plan->banner) || $plan->banner == '')) {
            $this->selectedPlanIdForBanner = $id;
            $this->selectedPlanName = $plan->plan_name;
            $this->showUploadModal = true;
            $this->bannerFile = null;

            return;
        }

        $plan->is_mobile = $targetStatus;
        $plan->save();

        session()->flash('message', 'Mobile visibility status updated for plan: '.$plan->plan_name);
    }

    public function uploadBanner()
    {
        $this->validate([
            'bannerFile' => 'required|image|max:2048',
        ]);

        $plan = Gn_PackagePlan::findOrFail($this->selectedPlanIdForBanner);

        $imageService = app(\App\Services\ImageService::class);
        $fullPath = $imageService->handleUploadCustom($this->bannerFile, 'package_banner', 600, 388);

        $plan->banner = $fullPath;
        $plan->is_mobile = 1;
        $plan->save();

        $this->closeUploadModal();

        session()->flash('message', 'Banner uploaded and Mobile View enabled successfully for plan: '.$plan->plan_name);
    }

    public function closeUploadModal()
    {
        $this->showUploadModal = false;
        $this->selectedPlanIdForBanner = null;
        $this->bannerFile = null;
    }

    public function toggleStatus($id)
    {
        $plan = Gn_PackagePlan::findOrFail($id);
        $plan->status = $plan->status == 1 ? 0 : 1;
        $plan->save();

        $statusText = $plan->status == 1 ? 'Activated' : 'Inactivated';
        session()->flash('message', 'Plan '.$statusText.' successfully: '.$plan->plan_name);
    }

    public function extendExpiry($id, $unit)
    {
        $amount = intval($this->extensionAmounts[$id] ?? 1);
        if ($amount < 1 || $amount > 30) {
            session()->flash('error', 'Invalid extend amount. Must be between 1 and 30.');

            return;
        }

        $plan = Gn_PackagePlan::findOrFail($id);
        $expire_date = $plan->expire_date;
        $current_date = date('Y-m-d');

        $base_date = ($expire_date && $expire_date >= $current_date) ? $expire_date : $current_date;

        if ($unit === 'W') {
            $days = $amount * 7;
            $new_expire_date = date('Y-m-d', strtotime($base_date." + {$days} days"));
        } elseif ($unit === 'M') {
            $new_expire_date = date('Y-m-d', strtotime($base_date." + {$amount} months"));
        } elseif ($unit === 'Y') {
            $new_expire_date = date('Y-m-d', strtotime($base_date." + {$amount} years"));
        } else {
            session()->flash('error', 'Invalid unit.');

            return;
        }

        $plan->expire_date = $new_expire_date;
        $plan->save();

        session()->flash('message', 'Extended package expiry for '.$plan->plan_name.' to '.date('d-M-Y', strtotime($new_expire_date)));
    }

    public function showDetails($id)
    {
        $plan = Gn_PackagePlan::findOrFail($id);
        $this->selectedPlanName = $plan->plan_name;

        // Fetch tests
        $this->selectedTests = $plan->test()->pluck('title')->toArray();

        // Fetch study notes materials
        $this->selectedNotes = Studymaterial::whereIn('id', explode(',', $plan->study_material_id))
            ->pluck('title')
            ->toArray();

        // Fetch video classes
        $this->selectedVideos = Studymaterial::whereIn('id', explode(',', $plan->video_id))
            ->pluck('title')
            ->toArray();

        // Fetch GK/Current affairs
        $this->selectedGK = Studymaterial::whereIn('id', explode(',', $plan->static_gk_id))
            ->pluck('title')
            ->toArray();

        $this->showDetailsModal = true;
    }

    public function closeDetailsModal()
    {
        $this->showDetailsModal = false;
        $this->selectedPlanName = '';
        $this->selectedTests = [];
        $this->selectedNotes = [];
        $this->selectedVideos = [];
        $this->selectedGK = [];
    }

    public function render()
    {
        $query = Gn_PackagePlan::query()
            ->leftJoin('franchise_details', function ($join) {
                $join->on('gn__package_plans.institute_id', '=', 'franchise_details.id')
                    ->whereNull('franchise_details.deleted_at');
            })
            ->leftjoin('classes_groups_exams', function ($join) {
                $join->on('classes_groups_exams.id', '=', 'gn__package_plans.class')
                    ->whereNull('classes_groups_exams.deleted_at');
            })
            ->select('gn__package_plans.*', 'franchise_details.institute_name as my_institute_name', 'classes_groups_exams.name as class_name');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('plan_name', 'like', '%'.$this->search.'%')
                    ->orWhere('classes_groups_exams.name', 'like', '%'.$this->search.'%');
            });
        }

        // Apply sorting (safeguard column injection)
        $allowedSortColumns = ['id', 'plan_name', 'is_featured', 'duration', 'final_fees', 'status', 'is_mobile', 'expire_date'];
        $sortCol = in_array($this->sortBy, $allowedSortColumns) ? $this->sortBy : 'id';

        $plans = $query->orderBy('gn__package_plans.'.$sortCol, $this->sortDirection)
            ->paginate(15);

        // Prepopulate amounts default values
        foreach ($plans as $plan) {
            if (! isset($this->extensionAmounts[$plan->id])) {
                $this->extensionAmounts[$plan->id] = 1;
            }
        }

        return view('livewire.admin.plans.manage-plans', [
            'plans' => $plans,
        ]);
    }
}
