<?php

namespace App\Livewire\Admin\Tests;

use App\Models\TestModal;
use Livewire\Component;
use Livewire\WithPagination;

class TestTable extends Component
{
    use WithPagination;

    public $search = '';

    public $test_cat = '';

    public $published = '';

    public $perPage = 10;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'search' => ['except' => ''],
        'test_cat' => ['except' => ''],
        'published' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function setCategory($value)
    {
        $this->test_cat = $value;
        $this->resetPage();
    }

    public function setPublished($value)
    {
        $this->published = $value;
        $this->resetPage();
    }

    public function toggleFeatured($testId)
    {
        $test = TestModal::find($testId);
        if ($test) {
            $test->featured = ! $test->featured;
            $test->save();
        }
    }

    public function deleteTest($testId)
    {
        $test = TestModal::find($testId);
        if ($test) {
            $test->delete();
            session()->flash('success', 'Test deleted successfully.');
        }
    }

    public function render()
    {
        $query = TestModal::select([
            'test.id as id',
            'test.user_id',
            'title',
            'sections as sections_count',
            'total_questions',
            'questions_submitted',
            'education_type_id',
            'test_cat',
            'price',
            'test_type',
            'questions_approved',
            'reviewed',
            'reviewed_status',
            'published',
            'test.created_at as created_at',
            'education_type_child_id',
            'published_status',
            'featured',
            'users.name as username',
            'franchise_details.institute_name as institute_name',
        ])
            ->leftJoin('users', function ($join) {
                $join->on('users.id', '=', 'test.user_id')
                    ->whereNull('users.deleted_at');
            })
            ->leftJoin('franchise_details', function ($join) {
                $join->on('franchise_details.user_id', '=', 'users.id')
                    ->whereNull('franchise_details.deleted_at');
            })
            ->with(['EducationClass', 'Educationtype', 'getTestCat', 'testSections'])
            ->withCount('getQuestions as confirmed_questions_count');

        if (! empty($this->search)) {
            $query->where('title', 'like', '%'.$this->search.'%');
        }

        if (! empty($this->test_cat)) {
            $query->where('test_cat', $this->test_cat);
        }

        if ($this->published !== '') {
            $publishId = ($this->published === 'true') ? 1 : 0;
            $query->where('published', $publishId);
        }

        $tests = $query->orderBy('test.id', 'desc')->paginate($this->perPage);

        return view('livewire.admin.tests.test-table', [
            'tests' => $tests,
        ]);
    }
}
