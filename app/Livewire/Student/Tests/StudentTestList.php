<?php

namespace App\Livewire\Student\Tests;

use App\Models\TestModal;
use App\Models\UserDetails;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class StudentTestList extends Component
{
    use WithPagination;

    public $type; // 1 for Institute, 0 for Gyanology

    public $cat;  // Category for Gyanology

    public $search = '';

    public $perPage = 10;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = Auth::user();
        $userDetails = UserDetails::where('user_id', $user->id)->first();

        // Base Query
        $query = TestModal::select([
            'id', 'title', 'sections', 'total_questions', 'questions_submitted',
            'questions_approved', 'reviewed', 'reviewed_status', 'published',
            'created_at', 'education_type_child_id', 'published_status',
        ])
            ->where('published', 1)
            ->with(['EducationClass', 'testAttempts' => function ($query) use ($user) {
                $query->where('student_id', $user->id);
            }])
            ->withCount('getQuestions as confirmed_questions_count');

        if ($this->type == 1) {
            // Institute Tests
            if ($user->myInstitute) {
                $query->where('education_type_id', $userDetails->education_type)
                    ->where('user_id', $user->myInstitute->user_id);
            } else {
                // Return empty if no institute
                return view('livewire.student.tests.student-test-list', [
                    'tests' => collect([]),
                ]);
            }
        } else {
            // Gyanology Tests
            $query->where('education_type_id', $userDetails->education_type)
                ->whereNull('user_id');

            if ($this->cat) {
                $query->where('test_cat', $this->cat);
            }
        }

        if (! empty($this->search)) {
            $query->where('title', 'like', '%'.$this->search.'%');
        }

        $tests = $query->orderBy('id', 'desc')->paginate($this->perPage);

        return view('livewire.student.tests.student-test-list', [
            'tests' => $tests,
        ]);
    }
}
