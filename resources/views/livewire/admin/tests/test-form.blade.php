<div class="container p-0">
    <form class="card dashboard-container mb-5" wire:submit.prevent="save" enctype="multipart/form-data">
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
            <div class="row">
                <div class="col-4">
                    <small><b>Test Image</b></small>
                    <input type="file" wire:model="test_image" class="form-control form-control-sm">
                    <div wire:loading wire:target="test_image">Uploading...</div>
                    @error('test_image') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>
                <div class="col-4">
                    @if ($test_image)
                        <img src="{{ $test_image->temporaryUrl() }}" style="width:80px;height:80px;border:1px solid #c2c2c2; object-fit:cover;">
                    @elseif($existing_image)
                        <img src="{{ '/storage/' . $existing_image }}" style="width:80px;height:80px;border:1px solid #c2c2c2; object-fit:cover;">
                    @else
                        <img src="{{ asset('noimg.png') }}" style="width:80px;height:80px;border:1px solid #c2c2c2; object-fit:cover;">
                    @endif
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-6">
                    <small><b>Test Title</b></small>
                    <input type="text" wire:model="title" class="form-control form-control-sm" placeholder="Test Title">
                    @error('title') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>
                <div class="col-6">
                    <small><b>Test Subtitle</b></small>
                    <input type="text" wire:model="sub_title" class="form-control form-control-sm" placeholder="Test Subtitle">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-3">
                    <small><b>Education Type</b></small>
                    <select wire:model.live="education_type_id" class="form-select form-select-sm">
                        <option value="">Select</option>
                        @foreach($educations as $edu)
                            <option value="{{ $edu->id }}">{{ $edu->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <small><b>Class/Group/Exam Name</b></small>
                    <select wire:model.live="class_group_exam_id" class="form-select form-select-sm">
                        <option value="">Select</option>
                        @foreach($classes as $cls)
                            <option value="{{ $cls->id }}">{{ $cls->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <small><b>Exam Agency/Board</b></small>
                    <select wire:model.live="exam_agency_board_university_id" class="form-select form-select-sm">
                        <option value="">Select</option>
                        @foreach($agencies as $agency)
                            <option value="{{ $agency->board_agency_exam_id }}">{{ $agency->agencyBoardUniversity->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <small><b>Other Exam Detail</b></small>
                    <select wire:model="other_exam_class_detail_id" class="form-select form-select-sm">
                        <option value="">Select</option>
                        @foreach($otherExams as $other)
                            <option value="{{ $other->id }}">{{ $other->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-3">
                    <small><b>Marks per Question</b></small>
                    <select wire:model="marks_per_questions" class="form-select form-select-sm">
                        <option value="">Select</option>
                        @foreach($marksOptions as $m)
                            <option value="{{ $m }}">{{ $m }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-3">
                    <small><b>Negative Marks</b></small>
                    <select wire:model="negative_marks" class="form-select form-select-sm">
                        @foreach($negativeMarksOptions as $nm)
                            <option value="{{ $nm['id'] }}">{{ $nm['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-3">
                    <small><b>Number of Sections</b></small>
                    <select wire:model="no_of_sections" class="form-select form-select-sm">
                        <option value="">Select</option>
                        @for($i=1; $i<=10; $i++)
                            <option value="{{ $i }}">{{ $i }} Sections</option>
                        @endfor
                    </select>
                    @error('no_of_sections') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>
                <div class="col-3">
                    <small><b>Total Questions</b></small>
                    <input type="number" wire:model="total_questions" class="form-control form-control-sm" placeholder="Total Questions" min="1">
                    @error('total_questions') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-4">
                    <small><b>Test Type</b></small>
                    <select wire:model.live="test_type" class="form-select form-select-sm">
                        <option value="1">Free</option>
                        <option value="0">Premium</option>
                    </select>
                </div>
                <div class="col-4">
                    <small><b>Price (if Premium)</b></small>
                    <input type="number" wire:model="price" class="form-control form-control-sm" placeholder="Price" {{ $test_type == 1 ? 'disabled' : '' }}>
                </div>
            </div>

            <!-- NEW: Package Integration -->
            <div class="row mt-3">
                <div class="col-12">
                    <small><b>Link to Packages</b></small>
                    <div class="p-2 border rounded" style="max-height: 150px; overflow-y: auto;">
                        @forelse($packages as $package)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $package->id }}" wire:model="selectedPackages" id="pkg_{{ $package->id }}">
                                <label class="form-check-label" for="pkg_{{ $package->id }}">
                                    {{ $package->plan_name }} ({{ $package->package_category }})
                                </label>
                            </div>
                        @empty
                            <span class="text-muted small">No packages found for this class.</span>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-4">
                    <small><b>Special Remark 1</b></small>
                    <input type="text" wire:model="special_remark_1" class="form-control form-control-sm">
                </div>
                <div class="col-4">
                    <small><b>Special Remark 2</b></small>
                    <input type="text" wire:model="special_remark_2" class="form-control form-control-sm">
                </div>
                <div class="col-4">
                    <small><b>Rating</b></small>
                    <input type="number" step="0.1" wire:model="rating" class="form-control form-control-sm">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <button type="submit" class="btn btn-success">
                        <span wire:loading wire:target="save" class="spinner-border spinner-border-sm mr-2"></span>
                        Save Test Details
                    </button>
                    @if($testId)
                        <span class="badge bg-info ms-2">Editing Test ID: {{ $testId }}</span>
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>
