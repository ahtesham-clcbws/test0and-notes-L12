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
        $rows = \App\Models\Gn_PackageTransaction::query()
            ->with(['plan'])
            ->where('student_id', Auth::id())
            ->whereHas('plan', function($q) {
                $q->where('final_fees', '>', 0);
            })
            ->when($this->search, function ($query) {
                $query->where('plan_name', 'like', '%'.$this->search.'%');
            })
            ->latest()
            ->paginate(10);

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
