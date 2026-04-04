<?php

namespace App\Livewire\Student;

use App\Models\Gn_PackageTransaction;
use App\Models\Gn_StudentTestAttempt;
use App\Models\TestModal;
use App\Models\UserDetails;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Dashboard extends Component
{
    public $quote;
    public $activePlans;
    public $testAttemptCount;
    public $testCount = [];
    public $testInstitute;
    public $notes_count;
    public $video_count;
    public $gk_count;
    public $comprehensive_count;
    public $short_notes_count;
    public $premium_count;
    public $test_cat;

    #[Layout('components.layouts.student-mary')]
    public function mount(): void
    {
        $user = Auth::user();
        $stud_id = $user->id;

        $userDetails = \App\Models\UserDetails::where('user_id', $stud_id)->first();

        if (! $userDetails) {
            $this->activePlans = collect();
            return;
        }

        $class = $userDetails->class;
        $education_type = $userDetails->education_type;

        // Corrected legacy logic from DashboardController
        $this->testAttemptCount = \App\Models\Gn_StudentTestAttempt::where('student_id', $stud_id)->count();

        $testTotal = \App\Models\TestModal::where('published', 1)
            ->where('education_type_id', $education_type)
            ->where('education_type_child_id', $class)
            ->where(function ($q) {
                $q->whereNull('user_id')->orWhere('user_id', 1);
            })->get();

        $this->test_cat = \App\Models\TestCat::get();
        foreach ($this->test_cat as $cat) {
            $this->testCount[$cat->id] = $testTotal->where('test_cat', $cat->id)->count();
        }

        if (! empty($user->myInstitute)) {
            $this->testInstitute = $user->myInstitute->test()
                ->where('published', 1)
                ->where('education_type_id', $education_type)
                ->where('education_type_child_id', $class)
                ->count();
        } else {
            $this->testInstitute = 0;
        }

        // Study Material Counts
        $baseMaterial = \App\Models\Studymaterial::whereIn('institute_id', [$user->myInstitute?->id, 0])
            ->where('education_type', $education_type)
            ->where('class', $class)
            ->where('status', 1)
            ->where('material_seen', 1);

        $this->notes_count = (clone $baseMaterial)->where('category', 'Study Notes & E-Books')->count();
        $this->video_count = (clone $baseMaterial)->where('category', 'Live & Video Classes')->count();
        $this->gk_count = (clone $baseMaterial)->where('category', 'Static GK & Current Affairs')->count();
        $this->comprehensive_count = (clone $baseMaterial)->where('category', 'Comprehensive Study Material')->count();
        $this->short_notes_count = (clone $baseMaterial)->where('category', 'Short Notes & One Liner')->count();
        $this->premium_count = (clone $baseMaterial)->where('category', 'Premium Study Notes')->count();

        // Finalize Quote
        $this->quote = collect([
            "Believe in yourself. You will definitely achieve your goal very soon!",
            "Success is the sum of small efforts, repeated day in and day out.",
            "Don’t stop until you’re proud. Every bit of hard work counts.",
            "The secret to getting ahead is getting started. Keep going!",
            "Hard work beats talent when talent doesn’t work hard.",
            "Dream big, work hard, stay focused, and surround yourself with good people.",
            "Your only limit is your mind. Push yourself to the next level.",
            "Focus on the goal, not the obstacles. Your time is coming.",
            "The future belongs to those who believe in the beauty of their dreams.",
            "It always seems impossible until it’s done. Take the first step.",
            "Education is the most powerful weapon which you can use to change the world.",
            "Don’t let what you cannot do interfere with what you can do.",
            "Success doesn't just find you. You have to go out and get it.",
            "The key to success is to focus on goals, not obstacles.",
            "Wake up with determination. Go to bed with satisfaction.",
            "Do something today that your future self will thank you for.",
            "Little things make big days. Small steps, big results.",
            "Push yourself, because no one else is going to do it for you.",
            "Great things never come from comfort zones. Step out and shine.",
            "Dream it. Wish it. Do it. Your potential is limitless.",
            "Success is not final; failure is not fatal: It is the courage to continue that counts.",
            "Challenges are what make life interesting. Overcoming them is what makes life meaningful.",
            "The expert in anything was once a beginner. Keep practicing.",
            "Work hard in silence, let your success be your noise.",
            "Your education is a dress rehearsal for a life that is yours to lead.",
            "Strive for progress, not perfection. Every day is a new chance.",
            "Success is the result of preparation, hard work, and learning from failure.",
            "The only way to do great work is to love what you do. Stay inspired.",
            "You are capable of more than you know. Trust the process.",
            "Consistency is the bridge between goals and accomplishment."
        ])->random();

        // Active Plans
        $this->activePlans = \App\Models\Gn_PackageTransaction::query()
            ->with('plan')
            ->where('student_id', $stud_id)
            ->where('plan_status', 1)
            ->get();
    }

    public function render()
    {
        return view('livewire.student.dashboard');
    }
}
