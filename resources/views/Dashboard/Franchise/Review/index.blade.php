@extends('Layouts.franchise')

@section('main')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 p-4">
            <h3 class="mb-4">Submit Institute Review</h3>

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
                <div class="card p-4 shadow-sm" style="border-radius: 12px; border: 1px solid #eee;">
                    <form action="{{ route('franchise.review.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="review_text" class="form-label fw-bold">
                                {{ $review ? 'Update Your Feedback' : 'Share your thoughts about the portal' }}
                            </label>
                            <textarea name="review_text" id="review_text" rows="5" class="form-control @error('review_text') is-invalid @enderror" placeholder="Your feedback helps us improve..." required>{{ $review->review_text ?? '' }}</textarea>
                            @error('review_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-between">
                            @if($review)
                                <button type="button" class="btn btn-secondary px-4" onclick="toggleReviewEdit()">Cancel</button>
                            @endif
                            <button type="submit" class="btn btn-primary px-4">
                                {{ $review ? 'Update Feedback' : 'Submit Feedback' }}
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
                            <i class="bi bi-pencil-square"></i> Edit Feedback
                        </button>
                    </div>

                    <div class="card p-3 shadow-sm mt-3" style="border-left: 5px solid {{ $review->is_approved ? '#198754' : '#ffc107' }};">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge {{ $review->is_approved ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ $review->is_approved ? 'Approved' : 'Pending Moderation' }}
                            </span>
                            <small class="text-muted">{{ $review->created_at->format('d M Y') }}</small>
                        </div>
                        <p class="mb-0">{{ $review->review_text }}</p>
                        @if($review->is_featured)
                            <div class="mt-2 text-primary">
                                <i class="bi bi-patch-check-fill"></i> <small>Featured Testimonial</small>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
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
        </div>
    </div>
</div>
@endsection
