<?php

namespace App\Livewire\Student\Feedback;

use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    public $review;

    public $review_text = '';

    public $message = '';

    #[Layout('components.layouts.student-mary')]
    public function mount()
    {
        $this->review = Review::where('user_id', Auth::id())->first();
        if ($this->review) {
            $this->review_text = $this->review->review_text;
        }
    }

    public function submit()
    {
        $this->validate([
            'review_text' => 'required|string|max:1000',
        ]);

        if ($this->review) {
            $this->review->update([
                'review_text' => $this->review_text,
                'is_approved' => false, // Reset approval status on edit
            ]);
            $this->message = 'Your feedback has been updated and is pending re-approval.';
        } else {
            Review::create([
                'user_id' => Auth::id(),
                'user_type' => 'student',
                'review_text' => $this->review_text,
                'is_approved' => false,
                'is_featured' => false,
            ]);
            $this->message = 'Thank you! Your feedback has been submitted and is pending approval.';
        }

        session()->flash('success', $this->message);
    }

    public function render()
    {
        return view('livewire.student.feedback.index');
    }
}
