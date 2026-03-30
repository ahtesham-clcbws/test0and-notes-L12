<?php

namespace App\Livewire\Student\Exams;

use App\Models\Gn_StudentTestAttempt;
use App\Models\TestCat;
use App\Models\TestModal;
use App\Models\UserDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public ?int $category = null;

    public int $type = 1; // 1 = Tests, 0 = Gyanology

    #[Layout('components.layouts.student-mary')]
    public function mount(): void
    {
        $routeName = Route::currentRouteName();
        if ($routeName === 'student.dashboard_gyanology_list') {
            $this->type = 0;
        }
    }

    #[Computed]
    public function categories()
    {
        return TestCat::orderBy('name')->get();
    }

    public function headers(): array
    {
        return [
            ['key' => 'title', 'label' => 'Test Title', 'class' => 'font-semibold'],
            ['key' => 'category_name', 'label' => 'Category', 'sortable' => false],
            ['key' => 'test_date', 'label' => 'Date', 'class' => 'hidden lg:table-cell'],
            ['key' => 'status', 'label' => 'Status', 'sortable' => false],
            ['key' => 'actions', 'label' => '', 'sortable' => false],
        ];
    }

    public function tests()
    {
        $stud_id = Auth::id();
        $userDetails = UserDetails::active()->where('user_id', $stud_id)->first();

        if (!$userDetails) {
            return collect();
        }

        $query = TestModal::query()
            ->with(['EducationClass']) // Assuming relationship exists
            ->where('published', 1)
            ->where('test_type', $this->type)
            ->where('education_type_id', $userDetails->education_type)
            ->where('education_type_child_id', $userDetails->class)
            ->where(function ($q) {
                $q->whereNull('user_id')->orWhere('user_id', 1);
            });

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->category) {
            $query->where('test_cat', $this->category);
        }

        $tests = $query->latest()->paginate(10);

        // Map attempt status
        $attempts = Gn_StudentTestAttempt::where('student_id', $stud_id)
            ->whereIn('test_id', $tests->pluck('id'))
            ->pluck('test_id')
            ->toArray();

        foreach ($tests as $test) {
            $test->is_attempted = in_array($test->id, $attempts);
            $test->category_name = $this->categories->firstWhere('id', $test->test_cat)?->name ?? 'Uncategorized';
        }

        return $tests;
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedCategory(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.student.exams.index', [
            'tests' => $this->tests(),
            'headers' => $this->headers(),
        ]);
    }
}
