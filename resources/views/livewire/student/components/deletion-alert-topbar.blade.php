<div>
    @if($hasPendingRequest)
        <div class="alert alert-danger mb-0 rounded-0 border-0 text-white d-flex align-items-center justify-content-between py-2 px-4" style="background-color: #dc3545; z-index: 9999; position: relative;">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill mr-2" style="font-size: 1.25rem;"></i>
                <span class="font-weight-bold">
                    Your account is scheduled for deletion! Remaining time to cancel: <span class="badge bg-white text-danger font-weight-bold ml-1">{{ $remainingTime }}</span>
                </span>
            </div>
            <div>
                <button type="button" class="btn btn-sm btn-light text-danger font-weight-bold" wire:click="cancelRequest" onclick="return confirm('Are you sure you want to cancel the account deletion request?')">
                    Cancel Deletion Request
                </button>
            </div>
        </div>
    @endif
</div>
