<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Review;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('Layouts.admin')]
class ManageReviews extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function toggleApproval($id)
    {
        $review = Review::find($id);
        $review->is_approved = !$review->is_approved;
        $review->save();

        session()->flash('message', 'Review status updated.');
    }

    public function toggleFeatured($id)
    {
        $review = Review::find($id);
        $review->is_featured = !$review->is_featured;
        $review->save();

        session()->flash('message', 'Featured status updated.');
    }

    public function deleteReview($id)
    {
        Review::find($id)->delete();
        session()->flash('message', 'Review deleted.');
    }

    public $selectedReviewReviewText = '';
    public $showModal = false;

    public function showReviewDetail($id)
    {
        $review = Review::find($id);
        $this->selectedReviewReviewText = $review->review_text;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedReviewReviewText = '';
    }

    public function render()
    {
        $reviews = Review::with('user')->latest()->paginate(10);
        return view('livewire.admin.manage-reviews', [
            'reviews' => $reviews
        ]);
    }
}
