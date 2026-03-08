<div class="container p-0">
    <div class="dashboard-container mb-5">
        
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i><strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i><strong>Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <!-- Section Information Header -->
                <div class="card shadow-sm border-0 mb-4 bg-light">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="text-primary fw-bold mb-0">
                                <i class="bi bi-journal-text me-2"></i> 
                                {{ $test->title }} - Section Management
                            </h5>
                            <a href="{{ route('administrator.dashboard_tests_list') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-arrow-left me-1"></i> Back to Tests
                            </a>
                        </div>
                        
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-secondary px-3 py-2 fw-normal fs-6">
                                <i class="bi bi-building"></i> {{ $test->EducationBoard->name ?? 'N/A' }} 
                            </span>
                            <span class="badge bg-secondary px-3 py-2 fw-normal fs-6">
                                <i class="bi bi-mortarboard"></i> {{ $test->EducationClass->name ?? 'N/A' }}
                            </span>
                            <span class="badge bg-info text-dark px-3 py-2 fw-normal fs-6">
                                <i class="bi bi-book"></i> Subject: {{ $section->sectionSubject->name ?? 'N/A' }}
                            </span>
                        </div>
                        
                        <hr>
                        
                        <!-- Progress Indicator -->
                        <div class="d-flex justify-content-between align-items-end mb-1">
                            <span class="fw-bold text-dark">Assigned Questions</span>
                            <span class="fw-bold {{ $currentlyAssigned == $totalAllowed ? 'text-success' : 'text-primary' }}">
                                {{ $currentlyAssigned }} / {{ $totalAllowed }}
                            </span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            @php 
                                $percentage = $totalAllowed > 0 ? ($currentlyAssigned / $totalAllowed) * 100 : 0; 
                                $bgClass = $currentlyAssigned == $totalAllowed ? 'bg-success' : 'bg-primary';
                            @endphp
                            <div class="progress-bar {{ $bgClass }} progress-bar-striped {{ $currentlyAssigned < $totalAllowed ? 'progress-bar-animated' : '' }}" 
                                 role="progressbar" style="width: {{ $percentage }}%" 
                                 aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        @if($currentlyAssigned == $totalAllowed)
                            <div class="text-end mt-1"><small class="text-success fw-bold"><i class="bi bi-check2-all"></i> Section Complete</small></div>
                        @endif
                    </div>
                </div>

                <!-- Already Assigned Questions Table -->
                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 text-dark fw-bold"><i class="bi bi-list-check text-success me-2"></i> Questions in this Section</h5>
                    </div>
                    <div class="card-body p-0">
                        @if($assignedQuestions->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-3" style="width: 5%">Sr</th>
                                            <th style="width: 40%">Question</th>
                                            <th style="width: 20%">Answer</th>
                                            <th style="width: 25%">Solution</th>
                                            <th class="text-end pe-3" style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($assignedQuestions as $idx => $mapping)
                                            <tr>
                                                <td class="ps-3 fw-bold text-muted">{{ $idx + 1 }}</td>
                                                <td><div class="text-truncate text-wrap" style="max-height: 80px; overflow:hidden;">{!! $mapping->question->question !!}</div></td>
                                                <td><div class="text-truncate text-wrap" style="max-height: 80px; overflow:hidden;">{!! $mapping->question->mcq_answer !!}</div></td>
                                                <td><div class="text-truncate text-wrap" style="max-height: 80px; overflow:hidden;">{!! $mapping->question->solution !!}</div></td>
                                                <td class="text-end pe-3">
                                                    <button class="btn btn-outline-danger btn-sm" wire:click="removeQuestion({{ $mapping->id }})" title="Remove from section" onclick="confirm('Are you sure you want to remove this question?') || event.stopImmediatePropagation()">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3 text-muted">
                                    <i class="bi bi-inbox fs-1"></i>
                                </div>
                                <h5 class="text-muted">No questions assigned yet</h5>
                                <p class="text-muted small">Select questions from the bank below to build this section.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <hr class="my-5">

                <!-- Question Bank Selection -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            <h5 class="mb-0 text-dark fw-bold"><i class="bi bi-cloud-arrow-down text-primary me-2"></i> Select from Question Bank</h5>
                            <button wire:click="openAddModal" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold shadow-sm">
                                <i class="bi bi-plus-lg me-1"></i> Add New Question
                            </button>
                        </div>
                        
                        @if($currentlyAssigned >= $totalAllowed)
                            <span class="badge bg-warning text-dark px-3 py-2"><i class="bi bi-lock-fill me-1"></i> Section Full</span>
                        @else
                            <span class="badge bg-success px-3 py-2"><i class="bi bi-unlock-fill me-1"></i> Space Available</span>
                        @endif
                    </div>
                    
                    <div class="card-body p-0">
                        @if($availableQuestions->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-3" style="width: 5%">Sr</th>
                                            <th style="width: 15%">Class</th>
                                            <th style="width: 30%">Question</th>
                                            <th style="width: 20%">Answer</th>
                                            <th style="width: 20%">Solution</th>
                                            <th class="text-end pe-3" style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($availableQuestions as $qidx => $qbank)
                                            <tr>
                                                <td class="ps-3 fw-bold text-muted">{{ $availableQuestions->firstItem() + $qidx }}</td>
                                                <td><span class="badge bg-light text-dark border">{{ $qbank->classGroup->name ?? 'N/A' }}</span></td>
                                                <td><div class="text-truncate text-wrap" style="max-height: 80px; overflow:hidden;">{!! $qbank->question !!}</div></td>
                                                <td><div class="text-truncate text-wrap" style="max-height: 80px; overflow:hidden;">{!! $qbank->mcq_answer !!}</div></td>
                                                <td><div class="text-truncate text-wrap" style="max-height: 80px; overflow:hidden;">{!! $qbank->solution !!}</div></td>
                                                <td class="text-end pe-3">
                                                    @if($currentlyAssigned >= $totalAllowed)
                                                        <button class="btn btn-secondary btn-sm" disabled title="Section is full">
                                                            <i class="bi bi-lock"></i> Full
                                                        </button>
                                                    @else
                                                        <button class="btn btn-primary btn-sm px-3" wire:click="addQuestion({{ $qbank->id }})" wire:loading.attr="disabled" wire:target="addQuestion({{ $qbank->id }})">
                                                            <span wire:loading.remove wire:target="addQuestion({{ $qbank->id }})">Add</span>
                                                            <span wire:loading wire:target="addQuestion({{ $qbank->id }})" class="spinner-border spinner-border-sm"></span>
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="p-3 border-top">
                                {{ $availableQuestions->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3 text-muted">
                                    <i class="bi bi-search fs-1"></i>
                                </div>
                                <h5>No Questions Found</h5>
                                <p class="text-muted small">No questions in the Question Bank match this section's criteria.</p>
                            </div>
                        @endif
                    </div>
                </div>
            
            </div>
        </div>
    </div>

    <!-- Inline Question Creation Modal -->
    <div class="modal fade @if($showAddModal) show d-block @endif" tabindex="-1" role="dialog" 
         style="background: rgba(0,0,0,0.5); overflow-y: auto;">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-primary text-white border-0 py-3">
                    <h5 class="modal-title fw-bold"><i class="bi bi-patch-plus me-2"></i>Create New Question</h5>
                    <button type="button" class="btn-close btn-close-white" wire:click="closeAddModal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Read-only Categorization Context -->
                    <div class="alert alert-info border-0 bg-info bg-opacity-10 d-flex flex-wrap gap-2 mb-4 p-3 rounded-4">
                        <span class="badge bg-white text-info border border-info border-opacity-25 px-2 py-1">
                            <i class="bi bi-tag-fill me-1"></i> {{ $section->sectionSubject->name ?? 'Subject' }}
                        </span>
                        @if($section->subject_part)
                            <span class="badge bg-white text-info border border-info border-opacity-25 px-2 py-1">
                                <i class="bi bi-layers-fill me-1"></i> Part: {{ $section->sectionPart->name ?? 'Part' }}
                            </span>
                        @endif
                        <span class="text-muted small ms-auto d-flex align-items-center">
                            <i class="bi bi-info-circle me-1"></i> Automatically linked to this section
                        </span>
                    </div>

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold small text-muted">Question Content</label>
                            <textarea wire:model="newQuestion.question" class="form-control rounded-3 bg-light border-0" rows="3" placeholder="Enter question text..."></textarea>
                            @error('newQuestion.question') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Question Type</label>
                            <select wire:model.live="newQuestion.question_type" class="form-select rounded-3 bg-light border-0">
                                <option value="1">MCQ (Multiple Choice)</option>
                                <option value="2">Subjective (Long Answer)</option>
                            </select>
                        </div>

                        @if($newQuestion['question_type'] == 1)
                            <div class="col-12 mt-4 animate__animated animate__fadeIn">
                                <h6 class="fw-bold mb-3"><i class="bi bi-ui-checks me-2 text-primary"></i>Options & Answer</h6>
                                <div class="row g-2">
                                    @foreach(['ans_1', 'ans_2', 'ans_3', 'ans_4'] as $field)
                                        <div class="col-md-6">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text bg-white border-0 fw-bold">{{ substr($field, -1) }}</span>
                                                <input type="text" wire:model="newQuestion.{{ $field }}" class="form-control border-0 bg-light rounded-3" placeholder="Option {{ substr($field, -1) }}">
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="col-12 mt-3">
                                        <label class="form-label fw-bold small text-success">Correct Answer</label>
                                        <select wire:model="newQuestion.mcq_answer" class="form-select rounded-3 bg-success bg-opacity-10 border-0 fw-bold text-success">
                                            <option value="ans_1">Option 1</option>
                                            <option value="ans_2">Option 2</option>
                                            <option value="ans_3">Option 3</option>
                                            <option value="ans_4">Option 4</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="col-md-6 mt-4">
                            <label class="form-label fw-bold small text-muted">Solution Placeholder</label>
                            <textarea wire:model="newQuestion.solution" class="form-control rounded-3 bg-light border-0" rows="2" placeholder="Brief answer/solution..."></textarea>
                        </div>

                        <div class="col-md-6 mt-4">
                            <label class="form-label fw-bold small text-muted">Explanation</label>
                            <textarea wire:model="newQuestion.explanation" class="form-control rounded-3 bg-light border-0" rows="2" placeholder="Why is this answer correct?"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-3 px-4 fw-semi-bold" wire:click="closeAddModal">Cancel</button>
                    <button type="button" class="btn btn-primary rounded-3 px-4 fw-bold shadow-sm" wire:click="saveNewQuestion">
                        <span wire:loading.remove wire:target="saveNewQuestion"><i class="bi bi-save me-2"></i>Create & Attach</span>
                        <span wire:loading wire:target="saveNewQuestion"><span class="spinner-border spinner-border-sm me-2"></span>Saving...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
