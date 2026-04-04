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

    public int $type = 1;
    public string $source = 'global'; // global, institute

    public array $sortBy = ['column' => 'id', 'direction' => 'desc'];

    #[Layout('components.layouts.student-mary')]
    public function mount(): void
    {
        $routeName = Route::currentRouteName();
        $path = request()->path();

        if (str_contains($routeName, 'gyanology')) {
            $this->type = 0;
        }
        
        // Ensure source is strictly matched to provide legacy parity
        if (str_contains($routeName, 'institute_tests') || str_contains($path, 'coaching-tests')) {
            $this->source = 'institute';
        } else {
            $this->source = 'global';
        }

        if (request()->route('cat')) {
            $this->category = (int) request()->route('cat');
        }
    }

    #[Computed]
    public function categories()
    {
        return TestCat::orderBy('cat_name')->get()->map(fn($c) => ['id' => $c->id, 'name' => $c->cat_name]);
    }

    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'w-1'],
            ['key' => 'title', 'label' => 'Test Title', 'class' => 'font-semibold'],
            ['key' => 'category_name', 'label' => 'Category', 'sortable' => false],
            ['key' => 'created_at', 'label' => 'Created', 'class' => 'hidden lg:table-cell'],
            ['key' => 'status', 'label' => 'Status', 'sortable' => false],
            ['key' => 'actions', 'label' => '', 'sortable' => false],
        ];
    }

    public function rows()
    {
        $stud_id = Auth::id();
        $userDetails = UserDetails::where('user_id', $stud_id)->first();

        if (! $userDetails) {
            return collect();
        }

        $query = TestModal::query()
            ->with(['EducationClass'])
            ->where('published', 1)
            ->where('education_type_id', $userDetails->education_type)
            ->where('education_type_child_id', $userDetails->class);

        // If no category is selected, use strictly matched types
        // Otherwise, allow any test belonging to that category
        if ($this->category) {
            $query->where('test_cat', $this->category);
        } else {
            $query->where('test_type', $this->type);
        }

        if ($this->source == 'institute' && Auth::user()->myInstitute) {
            $query->where('user_id', Auth::user()->myInstitute->user_id);
        } else {
            $query->where(function ($q) {
                $q->whereNull('user_id')->orWhere('user_id', 1);
            });
        }

        if ($this->search) {
            $query->where('title', 'like', '%'.$this->search.'%');
        }


        $tests = $query->orderBy($this->sortBy['column'], $this->sortBy['direction'])->paginate(10);

        // Map attempt status
        $attempts = Gn_StudentTestAttempt::where('student_id', $stud_id)
            ->whereIn('test_id', $tests->pluck('id'))
            ->pluck('test_id')
            ->toArray();

        foreach ($tests as $test) {
            $test->is_attempted = in_array($test->id, $attempts);
            $cat = $this->categories->firstWhere('id', $test->test_cat);
            $test->category_name = $cat['name'] ?? 'Uncategorized';
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
            'tests' => $this->rows(),
            'headers' => $this->headers(),
        ]);
    }
}
