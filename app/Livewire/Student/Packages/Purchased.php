<?php

namespace App\Livewire\Student\Packages;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Purchased extends Component
{
    use \Livewire\WithPagination;

    public string $search = '';

    public array $sortBy = ['direction' => 'desc', 'column' => 'id'];

    #[Layout('components.layouts.student-mary')]
    public function render()
    {
        $query = \App\Models\Gn_PackageTransaction::query()
            ->with(['plan'])
            ->where('student_id', Auth::id())
            ->whereHas('plan', function ($q) {
                $q->where('final_fees', '>', 0);
            })
            ->when($this->search, function ($query) {
                $query->where('plan_name', 'like', '%'.$this->search.'%');
            })
            ->get()
            ->sortBy(function ($item) {
                // Sorting priority: Active (1) > Expired (2) > InQueue (0) > Inactive (3)
                return match ((int) $item->plan_status) {
                    1 => 0,
                    2 => 1,
                    0 => 2,
                    3 => 3,
                    default => 4
                };
            })
            ->unique('plan_id');

        $rows = new \Illuminate\Pagination\LengthAwarePaginator(
            $query->forPage(\Illuminate\Pagination\Paginator::resolveCurrentPage(), 10),
            $query->count(),
            10,
            \Illuminate\Pagination\Paginator::resolveCurrentPage(),
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
        );

        $headers = [
            ['key' => 'plan_name', 'label' => 'Package Name'],
            ['key' => 'plan.package_type', 'label' => 'Type'],
            ['key' => 'plan_start_date', 'label' => 'Starts'],
            ['key' => 'plan_end_date', 'label' => 'Expires'],
            ['key' => 'plan.duration', 'label' => 'Duration'],
            ['key' => 'plan_status', 'label' => 'Status'],
            ['key' => 'actions', 'label' => '', 'sortable' => false],
        ];

        return view('livewire.student.packages.purchased', [
            'rows' => $rows,
            'headers' => $headers,
        ]);
    }
}
