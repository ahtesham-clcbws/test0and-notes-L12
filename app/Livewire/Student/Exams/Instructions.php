<?php

namespace App\Livewire\Student\Exams;

use App\Models\TestModal;
use App\Models\UserDetails;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Instructions extends Component
{
    public $testId;

    public $test;

    public $test_duration;

    public $user_data;

    public bool $termsAccepted = false;

    public bool $privacyAccepted = false;

    #[Layout('components.layouts.student-mary')]
    public function mount($name)
    {
        $this->testId = $name;
        $this->loadTestData();
    }

    public function loadTestData()
    {
        $this->test = TestModal::with(['getSection.sectionSubject'])->find($this->testId);

        if (! $this->test) {
            return redirect()->route('student.dashboard');
        }

        $this->test_duration = $this->test->duration;
        $this->user_data = UserDetails::where('user_id', Auth::id())->first();
    }

    public function startTest()
    {
        if (! $this->termsAccepted) {
            $this->addError('termsAccepted', 'Please accept the terms and conditions.');

            return;
        }

        if (! $this->privacyAccepted) {
            $this->addError('privacyAccepted', 'Please accept the privacy policy.');

            return;
        }

        return redirect()->route('student.start-test', [$this->testId]);
    }

    public function render()
    {
        return view('livewire.student.exams.instructions');
    }
}
