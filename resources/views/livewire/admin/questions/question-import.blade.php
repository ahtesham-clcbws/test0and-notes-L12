<div class="container-fluid h-100 d-flex flex-column align-items-center justify-content-center pb-5"
    style="min-height: 80vh;" x-data="{ isDragging: false }">

    <div class="card rounded-4 animate__animated animate__zoomIn overflow-hidden border-0 shadow-lg w-100">
        <div class="card-body p-4">
            <div class="mb-4 text-center">
                <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3 bg-opacity-10 p-3 shadow-sm">
                    <i class="bi bi-file-earmark-spreadsheet-fill text-primary fs-3"></i>
                </div>
                <h4 class="fw-bold text-dark mb-1">Mass Integration</h4>
                <p class="text-muted small mb-0">Import architectural blueprints of questions via Excel/CSV</p>
            </div>

            @if(!$showPreview)
            <!-- Categorization Selection Form -->
            <div class="mb-3">
                <h6 class="fw-bold text-secondary mb-2">1. Select Target Categories</h6>
                <div class="row g-2">
                    <div class="col-md-3 col-sm-6">
                        <label class="form-label fw-semibold">Education Type <span class="text-danger">*</span></label>
                        <select class="form-select bg-light border-2" wire:model.live="education_type_id">
                            <option value="">Select Education Type</option>
                            @foreach ($educationTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        @error('education_type_id')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <label class="form-label fw-semibold">Class / Group <span class="text-danger">*</span></label>
                        <select class="form-select bg-light border-2" wire:model.live="class_id"
                            @disabled(!$education_type_id)>
                            <option value="">Select Class/Group</option>
                            @foreach ($classes as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                        @error('class_id')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <label class="form-label fw-semibold">Board / Agency</label>
                        <select class="form-select bg-light border-2" wire:model="board_id"
                            @disabled(!$class_id)>
                            <option value="">Select Board/Agency</option>
                            @foreach ($boards as $b)
                                <option value="{{ $b->id }}">{{ $b->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <label class="form-label fw-semibold">Subject <span class="text-danger">*</span></label>
                        <select class="form-select bg-light border-2" wire:model.live="subject_id"
                            @disabled(!$class_id)>
                            <option value="">Select Subject</option>
                            @foreach ($subjects as $s)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                        @error('subject_id')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <label class="form-label fw-semibold">Subject Part</label>
                        <select class="form-select bg-light border-2" wire:model.live="part_id"
                            @disabled(!$subject_id)>
                            <option value="">Select Part</option>
                            @foreach ($parts as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <label class="form-label fw-semibold">Lesson / Chapter</label>
                        <select class="form-select bg-light border-2" wire:model="lesson_id"
                            @disabled(!$part_id)>
                            <option value="">Select Lesson/Chapter</option>
                            @foreach ($lessons as $l)
                                <option value="{{ $l->id }}">{{ $l->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 col-sm-12">
                        <label class="form-label fw-semibold">Question Type <span class="text-danger">*</span></label>
                        <select class="form-select bg-light border-2" wire:model.live="question_type">
                            <option value="1">MCQ (Multiple Choice Question)</option>
                            <option value="2">Subjective (Long Answer)</option>
                        </select>
                        @error('question_type')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <hr class="border-secondary my-3 border-opacity-25">
            <h6 class="fw-bold text-secondary mb-2">2. Upload File</h6>

            <div class="upload-zone rounded-4 bg-light border-2 border-dashed p-4 text-center transition-all"
                :class="isDragging ? 'border-primary bg-primary bg-opacity-10 scale-102 shadow-glow' : 'border-muted opacity-80'"
                @dragover.prevent="isDragging = true" @dragleave.prevent="isDragging = false"
                @drop.prevent="isDragging = false; $refs.fileInput.files = $event.dataTransfer.files; $refs.fileInput.dispatchEvent(new Event('change'))"
                @click="$refs.fileInput.click()">

                <input class="d-none" type="file" wire:model="file" x-ref="fileInput" accept=".xlsx,.xls,.csv">

                <div wire:loading.remove wire:target="file">
                    <i class="bi bi-cloud-arrow-up text-primary fs-1 display-6 d-block mb-2"></i>
                    <h6 class="fw-bold mb-2">Click or Drag & Drop</h6>
                    <span class="text-muted small">Supports .xlsx, .xls, .csv (Max 10MB)</span>
                </div>

                <div wire:loading wire:target="file">
                    <div class="spinner-grow text-primary mb-3" role="status"></div>
                    <h6 class="fw-bold mb-2">Analyzing Architecture...</h6>
                    <span class="text-muted small">Uploading encrypted data stream</span>
                </div>

                @if ($file)
                    <div class="animate__animated animate__fadeIn mt-4">
                        <div
                            class="d-flex align-items-center justify-content-center rounded-3 gap-3 border bg-white p-3 shadow-sm">
                            <i class="bi bi-file-check-fill text-success fs-4"></i>
                            <div class="text-start">
                                <span class="fw-bold d-block text-truncate"
                                    style="max-width: 250px">{{ $file->getClientOriginalName() }}</span>
                                <small class="text-muted">{{ number_format($file->getSize() / 1024 / 1024, 2) }}
                                    MB</small>
                            </div>
                            <button class="btn btn-sm btn-outline-danger rounded-circle border-0" type="button"
                                @click.stop wire:click="$set('file', null)">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>
                @endif
            </div>

            <div class="d-flex mt-4 gap-3 justify-content-center">
                <button class="btn btn-primary btn-lg rounded-3 fw-bold hover-glow py-3 shadow-lg transition-all"
                    wire:click="import" @disabled(!$file || $isImporting)>
                    <span wire:loading.remove wire:target="import">
                        <i class="bi bi-rocket-takeoff me-2"></i>Execute Import Strategy
                    </span>
                    <span wire:loading wire:target="import">
                        <span class="spinner-border spinner-border-sm me-2"></span>Integrating Records...
                    </span>
                </button>
                <a class="btn btn-light text-muted fw-semi-bold border-0 py-2"
                    href="{{ route('administrator.dashboard_question_list') }}">
                    Abort Mission
                </a>
            </div>

            <div class="border-top mt-4 border-opacity-10 pt-3 text-center">
                <a class="text-decoration-none small text-muted hover-primary transition-all"
                    href="{{ asset('samples/question_import_sample.xlsx') }}" download>
                    <i class="bi bi-download me-2"></i>Download Reference Schema Blueprint
                </a>
            </div>

            @else
            <!-- Preview Table -->
            <div class="animate__animated animate__fadeIn">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold text-secondary mb-0">Review Parsed Architecture ({{ count($previewData) }} Records)</h5>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-danger btn-sm rounded-3 fw-bold shadow-sm"
                            wire:click="cancelPreview" wire:loading.attr="disabled">
                            <i class="bi bi-x-circle me-1"></i>Discard
                        </button>
                        <button class="btn btn-success btn-sm rounded-3 fw-bold shadow-lg text-white"
                            wire:click="saveAll" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="saveAll"><i class="bi bi-check2-all me-1"></i>Confirm & Save</span>
                            <span wire:loading wire:target="saveAll"><span class="spinner-border spinner-border-sm me-1"></span>Processing...</span>
                        </button>
                    </div>
                </div>

                <div class="table-responsive rounded-4 border bg-white shadow-sm" style="max-height: 50vh;">
                    <table class="table table-hover table-bordered table-sm align-middle mb-0">
                        <thead class="bg-light sticky-top">
                            <tr>
                                <th class="text-muted small text-uppercase" style="width: 5%">#</th>
                                <th class="text-muted small text-uppercase" style="width: 25%">Question Text</th>
                                <th class="text-muted small text-uppercase" style="width: 10%">Type</th>
                                <th class="text-muted small text-uppercase" style="width: 40%">Options & Answers</th>
                                <th class="text-muted small text-uppercase" style="width: 20%">Solution Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($previewData as $index => $row)
                                <tr>
                                    <td class="text-center fw-bold">{{ $index + 1 }}</td>
                                    <td>
                                        <textarea class="form-control form-control-sm border-0 bg-light" rows="3" wire:model="previewData.{{ $index }}.question"></textarea>
                                    </td>
                                    <td>
                                        <select class="form-select form-select-sm border-0 bg-light" wire:model="previewData.{{ $index }}.question_type">
                                            <option value="1">MCQ</option>
                                            <option value="2">Subjective</option>
                                        </select>
                                    </td>
                                    <td>
                                        @if($row['question_type'] == 1)
                                            <div class="d-flex flex-column gap-1">
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text bg-white border-0 fw-bold">1</span>
                                                    <input type="text" class="form-control border-0 bg-light" wire:model="previewData.{{ $index }}.ans_1" placeholder="Option 1">
                                                </div>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text bg-white border-0 fw-bold">2</span>
                                                    <input type="text" class="form-control border-0 bg-light" wire:model="previewData.{{ $index }}.ans_2" placeholder="Option 2">
                                                </div>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text bg-white border-0 fw-bold">3</span>
                                                    <input type="text" class="form-control border-0 bg-light" wire:model="previewData.{{ $index }}.ans_3" placeholder="Option 3">
                                                </div>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text bg-white border-0 fw-bold">4</span>
                                                    <input type="text" class="form-control border-0 bg-light" wire:model="previewData.{{ $index }}.ans_4" placeholder="Option 4">
                                                </div>
                                                <div class="input-group input-group-sm mt-1">
                                                    <span class="input-group-text bg-success bg-opacity-10 border-0 fw-bold text-success">Ans</span>
                                                    <select class="form-select border-0 bg-success bg-opacity-10 text-success fw-bold" wire:model="previewData.{{ $index }}.mcq_answer">
                                                        <option value="ans_1">Opt 1</option>
                                                        <option value="ans_2">Opt 2</option>
                                                        <option value="ans_3">Opt 3</option>
                                                        <option value="ans_4">Opt 4</option>
                                                        <option value="ans_5">Opt 5</option>
                                                    </select>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted small fst-italic">N/A (Subjective)</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column gap-2">
                                            <textarea class="form-control form-control-sm border-0 bg-light" rows="2" placeholder="Solution" wire:model="previewData.{{ $index }}.solution"></textarea>
                                            <textarea class="form-control form-control-sm border-0 bg-light" rows="2" placeholder="Explanation" wire:model="previewData.{{ $index }}.explanation"></textarea>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No valid architecture extracted from blueprints.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Notification system for errors -->
    <div x-data="{ show: false, message: '', type: 'success' }"
         x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type; setTimeout(() => show = false, 5000)"
         class="position-fixed top-0 end-0 p-4" style="z-index: 10000">
        <div x-show="show" style="display: none;" x-transition.duration.300ms
             :class="type === 'success' ? 'bg-success shadow-success' : 'bg-danger shadow-danger'">
            <i class="bi"
                :class="type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill'"></i>
            <span class="fw-bold" x-text="message"></span>
        </div>
    </div>

    <style>
        .scale-102 {
            transform: scale(1.02);
        }

        .shadow-glow {
            box-shadow: 0 0 25px rgba(var(--bs-primary-rgb), 0.2);
        }

        .transition-all {
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .upload-zone {
            cursor: pointer;
            border-style: dashed;
        }

        .hover-glow:hover:not(:disabled) {
            box-shadow: 0 0 20px rgba(var(--bs-primary-rgb), 0.5);
            transform: translateY(-2px);
        }

        .fs-huge {
            font-size: 5rem;
        }
    </style>
</div>
