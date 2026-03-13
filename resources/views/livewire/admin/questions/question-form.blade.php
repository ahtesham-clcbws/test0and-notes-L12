<div class="container-fluid pb-5" x-data="{
    question_type: @entangle('question_type'),
    mcq_count: @entangle('mcq_options_count'),
    difficulty: @entangle('difficulty_level')
}">
    <!-- Header Section -->
    <div class="row animate__animated animate__fadeIn mb-4">
        <div
            class="col-12 d-flex justify-content-between align-items-center rounded-4 border border-opacity-10 bg-white p-3 shadow-sm">
            <div>
                <h4 class="fw-bold text-primary mb-0">
                    <i class="bi bi-patch-question me-2"></i>
                    {{ $questionId ? 'Refine Question' : 'Architect New Question' }}
                </h4>
                <p class="text-muted small mb-0 mt-1">Crafting precision content for the question bank</p>
            </div>
            <div class="d-flex gap-2">
                <a class="btn btn-light rounded-3 text-muted fw-semi-bold hover-translate-y border px-4 py-2 transition-all"
                    href="{{ route('administrator.dashboard_question_list') }}">
                    <i class="bi bi-arrow-left me-2"></i>Cancel
                </a>
                <button class="btn btn-primary rounded-3 fw-bold hover-glow border-0 px-4 py-2 shadow-sm transition-all"
                    wire:click="save" wire:loading.attr="disabled">
                    <span wire:loading.remove><i class="bi bi-save me-2"></i>Persist Changes</span>
                    <span wire:loading><span class="spinner-border spinner-border-sm me-2"></span>Saving...</span>
                </button>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Form Content -->
        <div class="col-lg-8 animate__animated animate__fadeInLeft">
            <!-- Content Group -->
            <div class="card rounded-4 mb-4 overflow-hidden border-0 shadow-sm">
                <div class="card-header bg-primary border-0 bg-opacity-10 px-4 py-3">
                    <h5 class="fw-bold text-primary-emphasis mb-0">
                        <i class="bi bi-file-earmark-text me-2"></i>Question Architecture
                    </h5>
                </div>
                <div class="card-body p-4">
                    <!-- Basic Meta -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small text-uppercase ls-1">Cognitive Challenge
                                (Difficulty %)</label>
                            <div class="d-flex align-items-center gap-3">
                                <input class="form-range grow" type="range" min="0" max="100"
                                    step="5" x-model="difficulty">
                                <span class="badge bg-primary rounded-pill px-3 py-2" style="min-width: 60px"
                                    x-text="difficulty + '%'"></span>
                            </div>
                            @error('difficulty_level')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small text-uppercase ls-1">Status</label>
                            <select class="form-select bg-light rounded-3 border-0 px-3 py-2" wire:model="status">
                                <option value="pending">Pending Review</option>
                                <option value="approved">Approved / Live</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small text-uppercase ls-1">Type</label>
                            <select class="form-select bg-light rounded-3 border-0 px-3 py-2" x-model="question_type">
                                <option value="1">MCQ (Multiple Choice)</option>
                                <option value="2">Subjective (Written)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Question Text -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted small text-uppercase ls-1">The Question</label>
                        <div class="editor-wrap rounded-4 overflow-hidden border" wire:ignore>
                            <textarea class="tinyMce" id="question_content" data-model="question_content">{!! $this->question_content !!}</textarea>
                        </div>
                        @error('question_content')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- MCQ Logic -->
                    <div class="mcq-logic-section" x-show="question_type == 1" x-transition.duration.400ms>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <label class="form-label fw-bold text-muted small text-uppercase ls-1 mb-0">Rational
                                Options</label>
                            <div class="btn-group btn-group-sm rounded-pill bg-light border p-1">
                                @foreach ([2, 3, 4, 5] as $count)
                                    <button class="btn rounded-pill px-3 transition-all" type="button"
                                        @click="mcq_count = {{ $count }}"
                                        :class="mcq_count == {{ $count }} ? 'btn-primary shadow-sm' :
                                            'btn-light text-muted border-0'">{{ $count }}</button>
                                @endforeach
                            </div>
                        </div>

                        <div class="row g-3">
                            @foreach ([1, 2, 3, 4, 5] as $i)
                                <div class="col-md-12" x-show="mcq_count >= {{ $i }}">
                                    <div
                                        class="card bg-light rounded-4 border border-opacity-10 bg-opacity-50 shadow-none">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center mb-2 gap-3">
                                                <div class="form-check m-0">
                                                    <input class="form-check-input custom-radio"
                                                        id="ans_{{ $i }}" name="correct_ans" type="radio"
                                                        value="{{ $i }}" wire:model="mcq_answer">
                                                    <label class="form-check-label fw-bold text-dark small"
                                                        for="ans_{{ $i }}">
                                                        MARK AS CORRECT OPTION {{ $i }}
                                                    </label>
                                                </div>
                                            </div>
                                            <div wire:ignore>
                                                <textarea class="tinyMce" id="ans_editor_{{ $i }}" data-model="ans_{{ $i }}">{!! $this->{'ans_' . $i} !!}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Feedback Group -->
                    <div class="row g-4 mt-2">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small text-uppercase ls-1">The Ideal
                                Solution</label>
                            <div class="editor-wrap rounded-3 border" wire:ignore>
                                <textarea class="tinyMce" id="solution" data-model="solution">{!! $this->solution !!}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small text-uppercase ls-1">Detailed
                                Explanation</label>
                            <div class="editor-wrap rounded-3 border" wire:ignore>
                                <textarea class="tinyMce" id="explanation" data-model="explanation">{!! $this->explanation !!}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Components -->
        <div class="col-lg-4 animate__animated animate__fadeInRight">
            <div class="sticky-top" style="top: 3rem;">
                <!-- Categorization -->
                <div class="card rounded-4 mb-4 border-0 shadow-sm">
                    <div class="card-header bg-light border-0 px-4 py-3">
                        <h6 class="fw-bold text-dark mb-0">Categorization & Mapping</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Education Type</label>
                            <select class="form-select custom-select" wire:model.live="education_type_id">
                                <option value="">Select Category</option>
                                @foreach ($educationTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                            @error('education_type_id')
                                <span class="text-danger x-small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Class / Group / Exam Name</label>
                            <select class="form-select custom-select" wire:model.live="class_id"
                                @disabled(!$education_type_id)>
                                <option value="">Select Class</option>
                                @foreach ($classes as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                            @error('class_id')
                                <span class="text-danger x-small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Board / Agency</label>
                            <select class="form-select custom-select" wire:model="board_id"
                                @disabled(!$class_id)>
                                <option value="">Select Board</option>
                                @foreach ($boards as $b)
                                    <option value="{{ $b->id }}">{{ $b->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Subject</label>
                            <select class="form-select custom-select" wire:model.live="subject_id"
                                @disabled(!$class_id)>
                                <option value="">Select Subject</option>
                                @foreach ($subjects as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Subject Part</label>
                            <select class="form-select custom-select" wire:model.live="part_id"
                                @disabled(!$subject_id)>
                                <option value="">Select Part</option>
                                @foreach ($parts as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Chapter</label>
                            <select class="form-select custom-select" wire:model.live="chapter_id"
                                @disabled(!$part_id)>
                                <option value="">Select Chapter</option>
                                @foreach ($chapters as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-0">
                            <label class="form-label small fw-bold text-muted">Lesson</label>
                            <select class="form-select custom-select" wire:model="lesson_id"
                                @disabled(!$chapter_id)>
                                <option value="">Select Lesson</option>
                                @foreach ($lessons as $l)
                                    <option value="{{ $l->id }}">{{ $l->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Extra Save Button for convenience -->
    <div class="row animate__animated animate__fadeInUp mt-4">
        <div class="col-12 rounded-4 mb-5 border border-opacity-10 bg-white p-3 text-end shadow-sm">
            <div class="d-flex justify-content-end gap-2">
                <a class="btn btn-light rounded-3 text-muted fw-semi-bold hover-translate-y border px-4 py-2 transition-all"
                    href="{{ route('administrator.dashboard_question_list') }}">
                    <i class="bi bi-arrow-left me-2"></i>Cancel
                </a>
                <button
                    class="btn btn-primary rounded-3 fw-bold hover-glow border-0 px-4 py-2 shadow-sm transition-all"
                    wire:click="save" wire:loading.attr="disabled">
                    <span wire:loading.remove><i class="bi bi-save me-2"></i>Persist Changes</span>
                    <span wire:loading><span class="spinner-border spinner-border-sm me-2"></span>Saving...</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Notification system replaced with SweetAlert2 in script block -->

    @once
        <script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
        <script>
            document.addEventListener('livewire:init', () => {
                // Setup Notifications
                Livewire.on('notify', (event) => {
                    let data = event[0] || event;
                    if (data && data.message && typeof Swal !== 'undefined') {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: data.type || 'success',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    }
                });

                const initTiny = (selector, modelName) => {
                    if (!window.tinymce) {
                        console.error('TinyMCE not found. Retrying...');
                        setTimeout(() => initTiny(selector, modelName), 500);
                        return;
                    }

                    tinymce.init({
                        selector: '#' + selector,
                        height: selector.includes('ans') ? 150 : 250,
                        menubar: false,
                        plugins: 'lists link image table code',
                        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image table | code',
                        branding: false,
                        automatic_uploads: true,
                        file_picker_types: 'image',
                        file_picker_callback: function(cb, value, meta) {
                            var input = document.createElement('input');
                            input.setAttribute('type', 'file');
                            input.setAttribute('accept', 'image/*');
                            input.onchange = function() {
                                var file = this.files[0];
                                var reader = new FileReader();
                                reader.onload = function() {
                                    var id = 'blobid' + (new Date()).getTime();
                                    var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                                    var base64 = reader.result.split(',')[1];
                                    var blobInfo = blobCache.create(id, file, base64);
                                    blobCache.add(blobInfo);
                                    cb(blobInfo.blobUri(), {
                                        title: file.name
                                    });
                                };
                                reader.readAsDataURL(file);
                            };
                            input.click();
                        },
                        setup: (editor) => {
                            editor.on('change', () => {
                                @this.set(modelName, editor.getContent());
                            });
                            editor.on('blur', () => {
                                @this.set(modelName, editor.getContent());
                            });
                        }
                    });
                };

                const autoInit = () => {
                    document.querySelectorAll('.tinyMce').forEach(el => {
                        if (!tinymce.get(el.id)) {
                            initTiny(el.id, el.dataset.model);
                        }
                    });
                };

                autoInit();

                Livewire.on('mcq-updated', () => {
                    setTimeout(autoInit, 100);
                });
            });
        </script>
        <style>
            .ls-1 {
                letter-spacing: 0.05em;
            }

            .x-small {
                font-size: 0.75rem;
            }

            .transition-all {
                transition: all 0.3s ease;
            }

            .hover-translate-y:hover {
                transform: translateY(-2px);
            }

            .hover-glow:hover {
                box-shadow: 0 0 15px rgba(var(--bs-primary-rgb), 0.4);
            }

            .custom-select {
                border: none;
                background-color: #f8f9fa;
                border-radius: 12px;
                padding: 0.75rem 1rem;
            }

            .form-range::-webkit-slider-thumb {
                background: var(--bs-primary);
            }

            .custom-radio {
                width: 1.25rem;
                height: 1.25rem;
                border: 2px solid #dee2e6;
            }

            .custom-radio:checked {
                background-color: #28a745;
                border-color: #28a745;
            }

            .glass-orb {
                position: absolute;
                top: -50px;
                right: -50px;
                width: 150px;
                height: 150px;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 50%;
                blur: 40px;
            }

            .editor-wrap {
                background: #fff;
            }

            .cke_chrome {
                border: none !important;
                box-shadow: none !important;
            }

            .cke_top {
                background: #f8f9fa !important;
                border-bottom: 1px solid #eee !important;
            }
        </style>
    @endonce
</div>
