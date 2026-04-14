<?php

namespace App\Livewire\Student\Packages;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

class Index extends Component
{
    use \Livewire\WithPagination;

    #[Url]
    public string $search = '';

    public string $type = 'premium'; // premium, free

    public array $sortBy = ['column' => 'id', 'direction' => 'desc'];

    public function mount(string $type = 'premium'): void
    {
        $this->type = $type;
    }

    #[Layout('components.layouts.student-mary')]
    public function render()
    {
        $user = Auth::user();
        $student = \App\Models\UserDetails::where('user_id', $user->id)->first();

        if (! $student) {
            return view('livewire.student.packages.index', ['rows' => collect(), 'headers' => []]);
        }

        $active_plans = \App\Models\Gn_PackageTransaction::where('student_id', $user->id)
            ->where('plan_status', 1)
            ->pluck('plan_id')
            ->toArray();

        $rows = \App\Models\Gn_PackagePlan::query()
            ->leftJoin('franchise_details', 'gn__package_plans.institute_id', 'franchise_details.id')
            ->select('gn__package_plans.*', 'franchise_details.institute_name as my_institute_name')
            ->where('gn__package_plans.status', 1)
            ->where('gn__package_plans.education_type', $student->education_type)
            ->where('gn__package_plans.class', $student->class)
            ->where(function ($q) use ($user) {
                $q->where('franchise_details.branch_code', $user->franchise_code)
                    ->orWhere('gn__package_plans.package_type', 0);
            })
            ->when($this->type == 'premium', function ($q) use ($active_plans) {
                $q->where('gn__package_plans.final_fees', '>', 0)
                    ->where('gn__package_plans.expire_date', '>=', date('Y-m-d'))
                    ->whereNotIn('gn__package_plans.id', $active_plans);
            })
            ->when($this->type == 'free', function ($q) use ($active_plans) {
                $q->where('gn__package_plans.final_fees', '=', 0)
                    ->whereNotIn('gn__package_plans.id', $active_plans);
            })
            ->when($this->search, function ($q) {
                $q->where('plan_name', 'like', '%'.$this->search.'%');
            })
            ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
            ->paginate(10);

        $headers = [
            ['key' => 'plan_name', 'label' => 'Package Name'],
            ['key' => 'package_type', 'label' => 'Provider'],
            ['key' => 'final_fees', 'label' => 'Fees'],
            ['key' => 'duration', 'label' => 'Validity'],
            ['key' => 'actions', 'label' => '', 'sortable' => false],
        ];

        return view('livewire.student.packages.index', [
            'rows' => $rows,
            'headers' => $headers,
        ]);
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }
}
