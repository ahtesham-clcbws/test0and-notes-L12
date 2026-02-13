<div>
    <style>
        .review-text-truncate {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: normal;
        }
        .badge-student { background-color: #e3f2fd; color: #0d47a1; border: 1px solid #bbdefb; }
        .badge-institute { background-color: #f3e5f5; color: #4a148c; border: 1px solid #e1bee7; }
        .table-v-align td { vertical-align: middle !important; }
        .swal2-container { z-index: 9999 !important; }
    </style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if (session()->has('message'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card shadow-sm border-0" style="border-radius: 12px;">
                    <div class="card-header bg-dark d-flex justify-content-between align-items-center" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                        <h3 class="card-title text-white mb-0">Manage Student/Institute Reviews</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover table-v-align m-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">ID</th>
                                    <th>User Information</th>
                                    <th>User Type</th>
                                    <th>Review Content</th>
                                    <th>Submitted On</th>
                                    <th class="text-center">Approval</th>
                                    <th class="text-center">Featured</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reviews as $review)
                                    <tr>
                                        <td class="ps-4 text-muted">{{ $review->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <div class="fw-bold">{{ $review->user->name ?? 'Unknown User' }}</div>
                                                    <small class="text-muted">{{ $review->user->email ?? '--' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge {{ $review->user_type == 'student' ? 'badge-student' : 'badge-institute' }} px-3 py-2">
                                                {{ ucfirst($review->user_type) }}
                                            </span>
                                        </td>
                                        <td style="max-width: 400px;">
                                            <div class="review-text-truncate">
                                                {{ $review->review_text }}
                                            </div>
                                            @if(strlen($review->review_text) > 100)
                                                <a href="javascript:void(0)" wire:click="showReviewDetail({{ $review->id }})" class="small text-primary fw-bold">Read More</a>
                                            @endif
                                        </td>
                                        <td>{{ $review->created_at->format('d M Y') }}</td>
                                        <td class="text-center">
                                            <div class="form-check form-switch d-inline-block">
                                                <input class="form-check-input ms-0" type="checkbox" role="switch"
                                                    wire:click="toggleApproval({{ $review->id }})"
                                                    {{ $review->is_approved ? 'checked' : '' }}
                                                    style="cursor: pointer; width: 40px; height: 20px;">
                                            </div>
                                            <div class="small mt-1 {{ $review->is_approved ? 'text-success' : 'text-warning' }}">
                                                {{ $review->is_approved ? 'Approved' : 'Pending' }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-check form-switch d-inline-block">
                                                <input class="form-check-input ms-0" type="checkbox" role="switch"
                                                    wire:click="toggleFeatured({{ $review->id }})"
                                                    {{ $review->is_featured ? 'checked' : '' }}
                                                    style="cursor: pointer; width: 40px; height: 20px;">
                                            </div>
                                        </td>
                                        <td class="text-end pe-4">
                                            <button wire:click="deleteReview({{ $review->id }})"
                                                wire:confirm="Are you sure you want to permanently delete this review?"
                                                class="btn btn-outline-danger btn-sm border-0" title="Delete Review">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <div class="text-muted mb-2"><i class="bi bi-inbox fs-2"></i></div>
                                            <div class="text-muted">No reviews found in the system.</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($reviews->hasPages())
                        <div class="card-footer bg-white border-top-0 py-3">
                            <div class="d-flex justify-content-end">
                                {{ $reviews->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Review Detail Modal -->
    @if($showModal)
        <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-lg border-0" style="border-radius: 15px;">
                    <div class="modal-header border-bottom-0">
                        <h5 class="modal-title fw-bold">Review Details</h5>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body py-4">
                        <p class="text-dark lead" style="line-height: 1.6;">{{ $selectedReviewReviewText }}</p>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-light px-4" wire:click="closeModal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
