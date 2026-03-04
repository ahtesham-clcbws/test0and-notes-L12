<div class="row g-4" x-data="{
    notify(type, message) {
        const toast = document.createElement('div');
        toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} position-fixed bottom-0 end-0 m-3 shadow-lg animate__animated animate__fadeInUp`;
        toast.style.zIndex = 9999;
        toast.innerHTML = `<i class='bi bi-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2'></i>${message}`;
        document.body.appendChild(toast);
        setTimeout(() => {
            toast.classList.replace('animate__fadeInUp', 'animate__fadeOutDown');
            setTimeout(() => toast.remove(), 500);
        }, 3000);
    }
}" @notify.window="notify($event.detail.type, $event.detail.message)">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white py-3 border-bottom-0">
                <div class="row align-items-center g-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                            <input wire:model.live.debounce.300ms="search" type="text" class="form-control bg-light border-0" placeholder="Search ID or Question content...">
                        </div>
                    </div>
                    <div class="col-md-8 text-end d-flex justify-content-end gap-2">
                        @if(count($selectedRows) > 0)
                            <div class="btn-group me-2 animate__animated animate__fadeIn">
                                <button type="button" class="btn btn-outline-success dropdown-toggle" data-bs-toggle="dropdown">
                                    Bulk Action ({{ count($selectedRows) }})
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                    <li><a class="dropdown-item" href="#" wire:click="bulkUpdateStatus('approved')"><i class="bi bi-check-circle me-2 text-success"></i>Approve Selected</a></li>
                                    <li><a class="dropdown-item" href="#" wire:click="bulkUpdateStatus('pending')"><i class="bi bi-clock me-2 text-warning"></i>Set to Pending</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="#" wire:click="bulkDelete()"><i class="bi bi-trash me-2"></i>Delete Selected</a></li>
                                </ul>
                            </div>
                        @endif
                        <a href="{{ route('administrator.dashboard_question_import') }}" class="btn btn-outline-primary rounded-3">
                            <i class="bi bi-upload me-1"></i> Import
                        </a>
                        <a href="{{ route('administrator.dashboard_question_add') }}" class="btn btn-primary rounded-3 px-4 shadow-sm">
                            <i class="bi bi-plus-lg me-1"></i> Add Question
                        </a>
                    </div>
                </div>
            </div>

            {{-- The old Filters Bar is replaced by the new sticky filter bar --}}
            <div class="sticky-top bg-white border-bottom shadow-sm" style="top: 0; z-index: 1020;">
                <div class="p-3">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                                <input type="text" wire:model.live.debounce.300ms="search" class="form-control border-start-0 ps-0" placeholder="Search questions...">
                            </div>
                        </div>
                        <div class="col-md-9 d-flex flex-wrap gap-2 align-items-center justify-content-end">
                            <select wire:model.live="education_type_id" class="form-select w-auto filter-select">
                                <option value="">All Education</option>
                                @foreach($educationTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                            <select wire:model.live="class_id" class="form-select w-auto filter-select" @disabled(!$education_type_id)>
                                <option value="">All Classes</option>
                                @foreach($classes as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                            <select wire:model.live="subject_id" class="form-select w-auto filter-select" @disabled(!$class_id)>
                                <option value="">All Subjects</option>
                                @foreach($subjects as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endforeach
                            </select>
                            <select wire:model.live="part_id" class="form-select w-auto filter-select" @disabled(!$subject_id)>
                                <option value="">All Parts</option>
                                @foreach($parts as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                            <select wire:model.live="lesson_id" class="form-select w-auto filter-select" @disabled(!$part_id)>
                                <option value="">All Lessons</option>
                                @foreach($lessons as $l)
                                    <option value="{{ $l->id }}">{{ $l->name }}</option>
                                @endforeach
                            </select>
                            <select wire:model.live="question_type" class="form-select w-auto filter-select">
                                <option value="">All Types</option>
                                <option value="1">MCQ</option>
                                <option value="2">Subjective</option>
                            </select>
                            <select wire:model.live="statusFilter" class="form-select w-auto filter-select">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small text-uppercase">
                            <tr>
                                <th class="ps-4" style="width: 50px;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" wire:model.live="selectAll">
                                    </div>
                                </th>
                                <th style="width: 80px;">ID</th>
                                <th>Question Details</th>
                                <th>Cat / Subject</th>
                                <th class="text-center">Complexity</th>
                                <th class="text-center">Status</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($questions as $question)
                                <tr wire:key="q-{{ $question->id }}" class="{{ in_array($question->id, $selectedRows) ? 'table-primary shadow-sm' : '' }}">
                                    <td class="ps-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{ $question->id }}" wire:model.live="selectedRows">
                                        </div>
                                    </td>
                                    <td class="fw-bold text-muted">#{{ $question->id }}</td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <div class="fw-semibold text-dark mb-1">
                                                {!! Str::limit(strip_tags($question->question, '<img>'), 120) !!}
                                            </div>
                                            <div class="d-flex gap-2 align-items-center">
                                                @if($question->question_type == 1)
                                                    <span class="badge rounded-pill bg-soft-info text-info small border border-info border-opacity-25" style="background-color: #e0f2fe; color: #0ea5e9;">
                                                        <i class="bi bi-list-check me-1"></i> MCQ ({{ $question->mcq_options }} Options)
                                                    </span>
                                                @else
                                                    <span class="badge rounded-pill bg-soft-secondary text-secondary small border" style="background-color: #f3f4f6;">
                                                        <i class="bi bi-fonts me-1"></i> Subjective
                                                    </span>
                                                @endif
                                                <small class="text-muted"><i class="bi bi-person me-1"></i> {{ $question->creator->name ?? 'Admin' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="small">
                                            <div class="text-dark fw-medium">{{ $question->classGroup->name ?? 'N/A' }}</div>
                                            <div class="text-muted">{{ $question->inSubject->name ?? 'N/A' }}</div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex flex-column align-items-center">
                                            <div class="progress w-100" style="height: 6px; max-width: 60px;">
                                                <div class="progress-bar bg-{{ $question->difficulty_level > 70 ? 'danger' : ($question->difficulty_level > 40 ? 'warning' : 'success') }}"
                                                     role="progressbar" style="width: {{ $question->difficulty_level }}%"></div>
                                            </div>
                                            <small class="text-muted mt-1">{{ $question->difficulty_level }}%</small>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $statusColors = [
                                                'approved' => 'success',
                                                'pending' => 'warning',
                                                'rejected' => 'danger'
                                            ];
                                            $color = $statusColors[$question->status] ?? 'secondary';
                                        @endphp
                                        <span class="badge rounded-pill bg-{{ $color }} bg-opacity-10 text-{{ $color }} px-3">
                                            {{ ucfirst($question->status) }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group shadow-sm">
                                            <a href="{{ route('administrator.dashboard_question_update', $question->id) }}" class="btn btn-sm btn-white border-end" title="Edit">
                                                <i class="bi bi-pencil-square text-primary"></i>
                                            </a>
                                            @if($question->status !== 'approved')
                                                <button wire:click="updateStatus({{ $question->id }}, 'approved')" class="btn btn-sm btn-white border-end" title="Approve">
                                                    <i class="bi bi-check2 text-success"></i>
                                                </button>
                                            @endif
                                            @if($question->status !== 'rejected')
                                                <button wire:click="updateStatus({{ $question->id }}, 'rejected')" class="btn btn-sm btn-white border-end" title="Reject">
                                                    <i class="bi bi-x-large text-danger"></i>
                                                </button>
                                            @endif
                                            <button wire:click="deleteQuestion({{ $question->id }})"
                                                    wire:confirm="Permanent Delete Question #{{ $question->id }}?"
                                                    class="btn btn-sm btn-white" title="Delete">
                                                <i class="bi bi-trash text-muted"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="py-4">
                                            <i class="bi bi-patch-question display-4 text-muted mb-3 d-block"></i>
                                            <h5>No Questions Found</h5>
                                            <p class="text-muted">Try adjusting your filters or search terms.</p>
                                            <button wire:click="$set('search', '')" class="btn btn-outline-primary btn-sm mt-2">Clear Search</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">Showing {{ $questions->firstItem() ?? 0 }} to {{ $questions->lastItem() ?? 0 }} of {{ $questions->total() }} questions</small>
                    {{ $questions->links() }}
                </div>
            </div>
        </div>
    </div>

    <style>
        .table-primary { background-color: #f0f7ff !important; }
        .bg-soft-info { background-color: #e0f2fe; }
        .bg-soft-secondary { background-color: #f3f4f6; }
        .btn-white { background-color: #fff; border: 1px solid #dee2e6; }
        .btn-white:hover { background-color: #f8f9fa; }
        .progress { background-color: #e9ecef; border-radius: 10px; }
        .form-check-input:checked { background-color: #0d6efd; border-color: #0d6efd; }
    </style>
</div>
