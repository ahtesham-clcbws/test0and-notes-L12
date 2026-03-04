<div class="container p-0">
    <form class="card dashboard-container mb-5" wire:submit.prevent="save">
        @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card-body">
            <!-- Part 1: Read-only Test details -->
            <div class="row">
                <div class="col-12">
                    <div class="alertx alert-primary mb-3 p-2 bg-light border rounded">
                        <small class="fw-bold">Test Title</small>
                        <input type="text" class="form-control form-control-sm" value="{{ $test->title ?? '' }}" disabled>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <div class="alertx alert-primary p-2 bg-light border rounded h-100">
                        <small class="fw-bold">Education Type</small>
                        <input type="text" class="form-control form-control-sm" value="{{ $test->Educationtype->name ?? '' }}" disabled>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="alertx alert-primary p-2 bg-light border rounded h-100">
                        <small class="fw-bold">Class/Group/Exam Name</small>
                        <input type="text" class="form-control form-control-sm" value="{{ $test->EducationClass->name ?? '' }}" disabled>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="alertx alert-primary p-2 bg-light border rounded h-100">
                        <small class="fw-bold">Exam Agency/Board</small>
                        <input type="text" class="form-control form-control-sm" value="{{ $test->EducationBoard->name ?? '' }}" disabled>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="alertx alert-primary p-2 bg-light border rounded h-100">
                        <small class="fw-bold">Other Exam Detail</small>
                        <input type="text" class="form-control form-control-sm" value="{{ $test->OtherCategoryClass->name ?? '' }}" disabled>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-3">
                    <div class="alertx alert-primary p-2 bg-light border rounded h-100">
                        <small class="fw-bold">Marks per Question</small>
                        <input type="text" class="form-control form-control-sm" value="{{ $test->gn_marks_per_questions ?? '' }}" disabled>
                    </div>
                </div>
                <div class="col-3">
                    <div class="alertx alert-primary p-2 bg-light border rounded h-100">
                        <small class="fw-bold">Negative Marks</small>
                        <input type="text" class="form-control form-control-sm" value="{{ $test->negative_marks == '0' ? 'No Negative Marking' : '-'.$test->negative_marks.'%' }}" disabled>
                    </div>
                </div>
                <div class="col-3">
                    <div class="alertx alert-primary p-2 bg-light border rounded h-100">
                        <small class="fw-bold">Sections Count</small>
                        <input type="text" class="form-control form-control-sm" value="{{ $test->sections ?? '' }}" disabled>
                    </div>
                </div>
                <div class="col-3">
                    <div class="alertx alert-primary p-2 bg-light border rounded h-100">
                        <small class="fw-bold">Total Questions</small>
                        <input type="text" class="form-control form-control-sm" value="{{ $test->total_questions ?? '' }}" disabled>
                    </div>
                </div>
            </div>

            <hr class="mb-4">
            
            <h5 class="text-primary fw-bold mb-3">Publish Settings</h5>

            <!-- Part 2: Publish Toggles & Package linking -->
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="border rounded p-3 text-center h-100 shadow-sm" style="background-color: #f8f9fa;">
                        <small class="fw-bold d-block mb-2">Publish Result</small>
                        <div class="form-check form-switch d-flex justify-content-center">
                            <input class="form-check-input" type="checkbox" wire:model="show_result" style="width: 2.5em; height: 1.25em;">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="border rounded p-3 text-center h-100 shadow-sm" style="background-color: #f8f9fa;">
                        <small class="fw-bold d-block mb-2">Publish Answer (R/W)</small>
                        <div class="form-check form-switch d-flex justify-content-center">
                            <input class="form-check-input" type="checkbox" wire:model="show_answer" style="width: 2.5em; height: 1.25em;">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="border rounded p-3 text-center h-100 shadow-sm" style="background-color: #f8f9fa;">
                        <small class="fw-bold d-block mb-2">Publish Solution</small>
                        <div class="form-check form-switch d-flex justify-content-center">
                            <input class="form-check-input" type="checkbox" wire:model="show_solution" style="width: 2.5em; height: 1.25em;">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="border rounded p-3 text-center h-100 shadow-sm" style="background-color: #f8f9fa;">
                        <small class="fw-bold d-block mb-2">Publish Rank</small>
                        <div class="form-check form-switch d-flex justify-content-center">
                            <input class="form-check-input" type="checkbox" wire:model="show_rank" style="width: 2.5em; height: 1.25em;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Test Type</label>
                    <select wire:model.live="test_type" class="form-select form-select-sm">
                        <option value="1">Free</option>
                        <option value="0">Premium</option>
                    </select>
                    @error('test_type') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>
                
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Test Category</label>
                    <select wire:model="test_cat" class="form-select form-select-sm">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->cat_name }}</option>
                        @endforeach
                    </select>
                    @error('test_cat') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>
                
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Test Fees</label>
                    <input type="number" wire:model="price" class="form-control form-control-sm" {{ $test_type == 1 ? 'disabled' : '' }}>
                    @error('price') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <label class="form-label small fw-bold text-primary">Link to Packages</label>
                    <div class="p-3 border rounded shadow-sm bg-light" style="max-height: 200px; overflow-y: auto;">
                        @forelse($availablePackages as $package)
                            <div class="form-check mb-2">
                                <input class="form-check-input shadow-sm" type="checkbox" value="{{ $package->id }}" wire:model="selectedPackages" id="pkg_{{ $package->id }}">
                                <label class="form-check-label ms-1" for="pkg_{{ $package->id }}">
                                    {{ $package->plan_name }} <span class="badge bg-secondary ms-2">{{ $package->package_category == '1' ? 'Free' : 'Premium' }}</span>
                                </label>
                            </div>
                        @empty
                            <div class="alert alert-warning mb-0 p-2 text-center">
                                <i class="bi bi-info-circle me-1"></i> No packages found for this class and test type.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-12 text-end">
                    <a href="{{ route('administrator.dashboard_tests_list') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-success px-4 bg-gradient shadow-sm">
                        <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-2"></span>
                        <i class="bi bi-rocket-takeoff me-1"></i> Publish Test
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
