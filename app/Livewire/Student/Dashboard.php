<?php

use App\Models\Gn_PackagePlan;
use App\Models\Gn_PackageTransaction;
use App\Models\Gn_StudentTestAttempt;
use App\Models\TestModal;
use App\Models\UserDetails;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Dashboard extends Component
{
    public array $stats = [];
    public $activePlans;

    #[Layout('components.layouts.student-mary')]
    public function mount(): void
    {
        $user = Auth::user();
        $stud_id = $user->id;
        
        $userDetails = UserDetails::active()->where('user_id', $stud_id)->first();
        
        if (!$userDetails) {
            $this->stats = [
                'attempts' => 0,
                'total_tests' => 0,
                'progress' => 0
            ];
            $this->activePlans = collect();
            return;
        }

        $class = $userDetails->class;
        $education_type = $userDetails->education_type;

        // Statistics
        $attemptCount = Gn_StudentTestAttempt::where('student_id', $stud_id)->count();
        
        $totalTests = TestModal::query()
            ->where('published', 1)
            ->where('education_type_id', $education_type)
            ->where('education_type_child_id', $class)
            ->where(function ($q) {
                $q->whereNull('user_id')->orWhere('user_id', 1);
            })->count();

        $this->stats = [
            'attempts' => $attemptCount,
            'total_tests' => $totalTests,
            'progress' => $totalTests > 0 ? round(($attemptCount / $totalTests) * 100) : 0
        ];

        // Active Plans
        $this->activePlans = Gn_PackageTransaction::query()
            ->with('plan') // This might need verification of relationship name
            ->where('student_id', $stud_id)
            ->where('plan_status', 1)
            ->get();
    }

    public function render()
    {
        return view('livewire.student.dashboard');
    }
}
