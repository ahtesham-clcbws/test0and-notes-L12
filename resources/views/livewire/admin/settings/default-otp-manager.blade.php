<div class="card shadow-sm border-0 rounded-3">
    <div class="card-header bg-white py-3 border-0">
        <h5 class="mb-0 fw-bold"><i class="bi bi-shield-lock-fill me-2 text-primary"></i> Master OTP Management</h5>
    </div>
    <div class="card-body">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            {{-- Add New Master OTP Form --}}
            <div class="col-md-4">
                <div class="p-4 bg-light rounded-3 border">
                    <h6 class="fw-bold mb-3">Add New Master OTP</h6>
                    <form wire:submit.prevent="save">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">6-Digit OTP</label>
                            <input type="text" wire:model="otp" class="form-control @error('otp') is-invalid @enderror" placeholder="e.g. 239887" maxlength="6">
                            @error('otp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Description / Purpose</label>
                            <textarea wire:model="description" class="form-control @error('description') is-invalid @enderror" placeholder="e.g. Testing Fallback / Dev Team Access" rows="2"></textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3 form-check form-switch">
                            <input class="form-check-input" type="checkbox" wire:model="is_active" id="isActiveSwitch">
                            <label class="form-check-label small fw-bold" for="isActiveSwitch">Mark as Active</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 fw-bold">
                            <span wire:loading.remove wire:target="save">Create Master OTP</span>
                            <span wire:loading wire:target="save">Creating...</span>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Master OTP List --}}
            <div class="col-md-8">
                <div class="d-flex justify-content-between mb-3 align-items-center">
                    <div class="input-group w-50">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" wire:model.live="search" class="form-control border-start-0" placeholder="Search OTPs or descriptions...">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>OTP</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($masterOtps as $otpRecord)
                                <tr>
                                    <td><code class="fs-5 fw-bold text-dark">{{ $otpRecord->otp }}</code></td>
                                    <td><small>{{ $otpRecord->description }}</small></td>
                                    <td>
                                        <div class="form-check form-switch" wire:key="otp-{{ $otpRecord->id }}-switch">
                                            <input class="form-check-input" type="checkbox" wire:click="toggleActive({{ $otpRecord->id }})" {{ $otpRecord->is_active ? 'checked' : '' }}>
                                            <span class="badge rounded-pill {{ $otpRecord->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $otpRecord->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td><small>{{ $otpRecord->created_at->format('d M, Y') }}</small></td>
                                    <td class="text-end">
                                        <button wire:confirm="Are you sure you want to delete this Master OTP?" wire:click="delete({{ $otpRecord->id }})" class="btn btn-sm btn-outline-danger shadow-none border-0">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No Master OTPs found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $masterOtps->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
