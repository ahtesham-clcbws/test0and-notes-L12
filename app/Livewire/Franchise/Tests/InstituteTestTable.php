<?php

namespace App\Livewire\Franchise\Tests;

use App\Mail\NotifyTestUpdate;
use App\Models\FranchiseDetails;
use App\Models\TestModal;
use App\Models\TestSections;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;

class InstituteTestTable extends Component
{
    use WithPagination;

    public $viewMode = 'owner'; // 'owner', 'creater', 'publisher', 'manager'

    public $search = '';

    public $test_cat = '';

    public $published = '';

    public $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'test_cat' => ['except' => ''],
        'published' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deleteTest($id)
    {
        if ($this->viewMode !== 'owner' && $this->viewMode !== 'manager') {
            return;
        }

        $test = TestModal::find($id);
        if ($test) {
            // Check ownership for owner mode
            if ($this->viewMode === 'owner' && $test->user_id != Auth::id()) {
                session()->flash('error', 'Unauthorized action.');

                return;
            }

            $test->delete();
            session()->flash('success', 'Test deleted successfully.');
        }
    }

    public function sentToPublisher($sectionId)
    {
        $section = TestSections::find($sectionId);
        if ($section) {
            $section->sent_to_publisher = 1;
            $section->save();

            $this->sendNotifications($section, 'created');
            session()->flash('success', 'Section sent to publisher.');
        }
    }

    public function publishSection($sectionId)
    {
        $section = TestSections::find($sectionId);
        if ($section) {
            $section->is_published = 1;
            $section->save();

            $this->sendNotifications($section, 'published');
            session()->flash('success', 'Section published.');
        }
    }

    protected function sendNotifications($section, $type)
    {
        try {
            $test_details = [
                'subject' => ($type === 'created' ? 'Test created for ' : 'Test published for ').$section->subject,
            ];

            // 1. Super Admins
            $super_admins = User::where('roles', 'superadmin')->where('status', 'active')->where('deleted_at', null)->pluck('email')->toArray();
            if (! empty($super_admins)) {
                Mail::to($super_admins)->send(new NotifyTestUpdate($test_details));
            }

            // 2. Creator or Publisher
            $targetUserId = ($type === 'created') ? $section->publisher_id : $section->creator_id;
            $targetUser = User::where('id', $targetUserId)->where('status', 'active')->where('deleted_at', null)->first();

            if ($targetUser) {
                Mail::to($targetUser->email)->send(new NotifyTestUpdate($test_details));
            }

            // 3. Institute
            $br_code = '';
            if ($targetUser && $targetUser->franchise_code) {
                $inst = FranchiseDetails::where('branch_code', $targetUser->franchise_code)->first();
                $br_code = $targetUser->franchise_code;
            } else {
                $test = TestModal::find($section->test_id);
                $inst = FranchiseDetails::where('user_id', $test->user_id)->first();
                $br_code = $inst ? $inst->branch_code : '';
            }

            if ($inst) {
                $instOwner = User::find($inst->user_id);
                if ($instOwner) {
                    Mail::to($instOwner->email)->send(new NotifyTestUpdate($test_details));
                }
            }

            // 4. Students (only on publish)
            if ($type === 'published' && $br_code) {
                $students = User::where('roles', 'student')
                    ->where('franchise_code', $br_code)
                    ->where('status', 'active')
                    ->where('deleted_at', null)
                    ->pluck('email')
                    ->toArray();

                if (! empty($students)) {
                    Mail::to($students)->send(new NotifyTestUpdate($test_details));
                }
            }

        } catch (\Throwable $th) {
            Log::error('Error sending test notifications: '.$th->getMessage());
        }
    }

    public function getRoute($name, $params = [])
    {
        $prefix = match ($this->viewMode) {
            'creater' => 'franchise.management.creater.',
            'publisher' => 'franchise.management.publisher.',
            'manager' => 'franchise.management.manager.',
            default => 'franchise.',
        };

        return route($prefix.$name, $params);
    }

    public function render()
    {
        $query = $this->getBaseQuery();
        $this->applyFilters($query);

        $results = $query->paginate($this->perPage);

        return view('livewire.franchise.tests.institute-test-table', [
            'results' => $results,
        ]);
    }

    protected function getBaseQuery()
    {
        if ($this->viewMode === 'owner') {
            return TestModal::where('user_id', Auth::id())
                ->withCount('getQuestions as questions_count')
                ->with(['EducationClass', 'Educationtype', 'getTestCat', 'getQuestions', 'getSection']);
        }

        // Staff Modes (creater, publisher, manager)
        return TestSections::query()
            ->join('test', function ($join) {
                $join->on('test_section.test_id', '=', 'test.id')
                    ->whereNull('test.deleted_at');
            })
            ->leftJoin('users', function ($join) {
                $join->on('users.id', 'test.user_id')
                    ->whereNull('users.deleted_at');
            })
            ->select([
                'test_section.*',
                'test.title as test_title',
                'test.sections as total_test_sections',
                'test.published as test_published',
                'test.reviewed as test_reviewed',
                'test.reviewed_status as test_reviewed_status',
                'test.created_at as test_created_at',
                'test.education_type_id',
                'test.education_type_child_id',
                'users.name as owner_name',
            ])
            ->where(function ($q) {
                $q->where('test_section.creator_id', Auth::id())
                    ->orWhere('test_section.publisher_id', Auth::id());
            })
            ->withCount('getQuestions as questions_count')
            ->with(['test', 'test.EducationClass', 'test.Educationtype', 'getQuestions']);
    }

    protected function applyFilters($query)
    {
        $field = $this->viewMode === 'owner' ? 'title' : 'test.title';

        if ($this->search) {
            $query->where($field, 'like', '%'.$this->search.'%');
        }

        if ($this->test_cat && $this->viewMode === 'owner') {
            $query->where('test_cat', $this->test_cat);
        }

        if ($this->published !== '' && $this->viewMode === 'owner') {
            $query->where('published', $this->published === 'true' ? 1 : 0);
        }
    }
}
