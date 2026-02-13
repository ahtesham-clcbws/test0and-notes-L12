@extends('Layouts.student')

@section('main')
<div class="container p-0">
    <div class="dashboard-container p-4">
        <h3 class="mb-4">Submit Your Review</h3>

        @if(session('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div id="reviewFormSection" style="{{ $review ? 'display:none;' : '' }}">
            <div class="card p-4 shadow-sm" style="border-radius: 15px; border: 1px solid #ddd;">
                <form action="{{ route('student.review.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="review_text" class="form-label font-weight-bold">
                            {{ $review ? 'Update Your Review' : 'Your Message' }}
                        </label>
                        <textarea name="review_text" id="review_text" rows="5" class="form-control @error('review_text') is-invalid @enderror" placeholder="Write your review here..." required>{{ $review->review_text ?? '' }}</textarea>
                        @error('review_text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-between">
                        @if($review)
                            <button type="button" class="btn btn-secondary px-4" onclick="toggleReviewEdit()">Cancel</button>
                        @endif
                        <button type="submit" class="btn btn-primary px-4" style="background-color: #007bff; border: none; border-radius: 8px;">
                            {{ $review ? 'Update Review' : 'Submit Review' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if($review)
            <div id="reviewDisplaySection">
                <div class="alert alert-info border-info shadow-sm d-flex justify-content-between align-items-center" style="border-radius: 12px;">
                    <div>
                        <i class="bi bi-info-circle-fill me-2"></i> You have already submitted a review.
                    </div>
                    <button class="btn btn-sm btn-outline-primary" onclick="toggleReviewEdit()">
                        <i class="bi bi-pencil-square"></i> Edit Review
                    </button>
                </div>

                <div class="card p-3 shadow-sm mt-3" style="border-radius: 12px; border-left: 5px solid {{ $review->is_approved ? '#28a745' : '#ffc107' }};">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge {{ $review->is_approved ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $review->is_approved ? 'Approved' : 'Pending Moderation' }}
                        </span>
                        <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                    </div>
                    <p class="mb-0 text-dark">{{ $review->review_text }}</p>
                    @if($review->is_featured)
                        <div class="mt-2 text-primary">
                            <i class="bi bi-star-fill"></i> <small>Featured Testimonial</small>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>

@section('javascript')
<script>
    function toggleReviewEdit() {
        const formSection = document.getElementById('reviewFormSection');
        const displaySection = document.getElementById('reviewDisplaySection');

        if (formSection.style.display === 'none') {
            formSection.style.display = 'block';
            if (displaySection) displaySection.style.display = 'none';
        } else {
            formSection.style.display = 'none';
            if (displaySection) displaySection.style.display = 'block';
        }
    }
</script>
@endsection
@endsection
