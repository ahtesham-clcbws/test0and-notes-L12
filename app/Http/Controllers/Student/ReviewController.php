<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index()
    {
        $review = Review::where('user_id', Auth::id())->first();
        return view('Dashboard/Student/Review/index', compact('review'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'review_text' => 'required|string|max:1000',
        ]);

        // Check if user already submitted a review (paranoia check)
        if (Review::where('user_id', Auth::id())->exists()) {
            return $this->update($request);
        }

        Review::create([
            'user_id' => Auth::id(),
            'user_type' => 'student',
            'review_text' => $request->review_text,
            'is_approved' => false,
            'is_featured' => false,
        ]);

        return redirect()->back()->with('message', 'Thank you! Your feedback has been submitted and is pending approval.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'review_text' => 'required|string|max:1000',
        ]);

        $review = Review::where('user_id', Auth::id())->firstOrFail();

        $review->update([
            'review_text' => $request->review_text,
            'is_approved' => false, // Reset approval status on edit
        ]);

        return redirect()->back()->with('message', 'Your feedback has been updated and is pending re-approval.');
    }
}
