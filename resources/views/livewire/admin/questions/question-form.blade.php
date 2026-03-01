<div class="container-fluid pb-5" x-data="{
    question_type: @entangle('question_type'),
    mcq_count: @entangle('mcq_options_count'),
    difficulty: @entangle('difficulty_level')
}">
    <!-- Header Section -->
    <div class="row mb-4 animate__animated animate__fadeIn">
        <div class="col-12 d-flex justify-content-between align-items-center bg-white p-3 rounded-4 shadow-sm border border-opacity-10">
            <div>
                <h4 class="mb-0 fw-bold text-primary">
                    <i class="bi bi-patch-question me-2"></i>
                    {{ $questionId ? 'Refine Question' : 'Architect New Question' }}
                </h4>
                <p class="text-muted small mb-0 mt-1">Crafting precision content for the question bank</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('administrator.dashboard_question_list') }}" class="btn btn-light border rounded-3 px-4 py-2 text-muted fw-semi-bold transition-all hover-translate-y">
                    <i class="bi bi-arrow-left me-2"></i>Cancel
                </a>
                <button wire:click="save" wire:loading.attr="disabled" class="btn btn-primary rounded-3 px-4 py-2 shadow-sm fw-bold border-0 transition-all hover-glow">
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
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                <div class="card-header bg-primary bg-opacity-10 border-0 py-3 px-4">
                    <h5 class="mb-0 fw-bold text-primary-emphasis">
                        <i class="bi bi-file-earmark-text me-2"></i>Question Architecture
                    </h5>
                </div>
                <div class="card-body p-4">
                    <!-- Basic Meta -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small text-uppercase ls-1">Cognitive Challenge (Difficulty %)</label>
                            <div class="d-flex align-items-center gap-3">
                                <input type="range" class="form-range grow" min="0" max="100" step="5" x-model="difficulty">
                                <span class="badge bg-primary rounded-pill px-3 py-2" style="min-width: 60px" x-text="difficulty + '%'"></span>
                            </div>
                            @error('difficulty_level') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small text-uppercase ls-1">Status</label>
                            <select wire:model="status" class="form-select border-0 bg-light rounded-3 px-3 py-2">
                                <option value="pending">Pending Review</option>
                                <option value="approved">Approved / Live</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small text-uppercase ls-1">Type</label>
                            <select x-model="question_type" class="form-select border-0 bg-light rounded-3 px-3 py-2">
                                <option value="1">MCQ (Multiple Choice)</option>
                                <option value="2">Subjective (Written)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Question Text -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted small text-uppercase ls-1">The Question</label>
                        <div wire:ignore class="editor-wrap rounded-4 overflow-hidden border">
                            <textarea id="question_content" class="ckeditor-instance" data-model="question_content">{{ $this->question_content }}</textarea>
                        </div>
                        @error('question_content') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <!-- MCQ Logic -->
                    <div x-show="question_type == 1" x-transition.duration.400ms class="mcq-logic-section">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <label class="form-label fw-bold text-muted small text-uppercase ls-1 mb-0">Rational Options</label>
                            <div class="btn-group btn-group-sm rounded-pill p-1 bg-light border">
                                @foreach([2,3,4,5] as $count)
                                    <button type="button" @click="mcq_count = {{ $count }}"
                                            :class="mcq_count == {{ $count }} ? 'btn-primary shadow-sm' : 'btn-light text-muted border-0'"
                                            class="btn rounded-pill px-3 transition-all">{{ $count }}</button>
                                @endforeach
                            </div>
                        </div>

                        <div class="row g-3">
                            @foreach([1,2,3,4,5] as $i)
                                <div class="col-md-12" x-show="mcq_count >= {{ $i }}">
                                    <div class="card border border-opacity-10 shadow-none bg-light bg-opacity-50 rounded-4">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center gap-3 mb-2">
                                                <div class="form-check m-0">
                                                    <input class="form-check-input custom-radio" type="radio" name="correct_ans" id="ans_{{ $i }}" value="{{ $i }}" wire:model="mcq_answer">
                                                    <label class="form-check-label fw-bold text-dark small" for="ans_{{ $i }}">
                                                        MARK AS CORRECT OPTION {{ $i }}
                                                    </label>
                                                </div>
                                            </div>
                                            <div wire:ignore>
                                                <textarea id="ans_editor_{{ $i }}" class="ckeditor-instance" data-model="ans_{{ $i }}">{{ $this->{'ans_' . $i} }}</textarea>
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
                            <label class="form-label fw-bold text-muted small text-uppercase ls-1">The Ideal Solution</label>
                            <div wire:ignore class="editor-wrap rounded-3 border">
                                <textarea id="solution" class="ckeditor-instance" data-model="solution">{{ $this->solution }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small text-uppercase ls-1">Detailed Explanation</label>
                            <div wire:ignore class="editor-wrap rounded-3 border">
                                <textarea id="explanation" class="ckeditor-instance" data-model="explanation">{{ $this->explanation }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Components -->
        <div class="col-lg-4 animate__animated animate__fadeInRight">
            <div class="sticky-top" style="top: 2rem;">
                <!-- Categorization -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-light border-0 py-3 px-4">
                        <h6 class="mb-0 fw-bold text-dark">Categorization & Mapping</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Education Type</label>
                            <select wire:model.live="education_type_id" class="form-select custom-select">
                                <option value="">Select Category</option>
                                @foreach($educationTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                            @error('education_type_id') <span class="text-danger x-small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Academic Class</label>
                            <select wire:model.live="class_id" class="form-select custom-select" @disabled(!$education_type_id)>
                                <option value="">Select Class</option>
                                @foreach($classes as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                            @error('class_id') <span class="text-danger x-small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Board / Agency</label>
                            <select wire:model="board_id" class="form-select custom-select" @disabled(!$class_id)>
                                <option value="">Select Board</option>
                                @foreach($boards as $b)
                                    <option value="{{ $b->id }}">{{ $b->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Subject</label>
                            <select wire:model.live="subject_id" class="form-select custom-select" @disabled(!$class_id)>
                                <option value="">Select Subject</option>
                                @foreach($subjects as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Subject Part</label>
                            <select wire:model.live="part_id" class="form-select custom-select" @disabled(!$subject_id)>
                                <option value="">Select Part</option>
                                @foreach($parts as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-0">
                            <label class="form-label small fw-bold text-muted">Lesson / Chapter</label>
                            <select wire:model="lesson_id" class="form-select custom-select" @disabled(!$part_id)>
                                <option value="">Select Lesson</option>
                                @foreach($lessons as $l)
                                    <option value="{{ $l->id }}">{{ $l->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Guidance Info -->
                <div class="card border-0 bg-primary bg-gradient text-white rounded-4 shadow-sm overflow-hidden">
                    <div class="card-body p-4 relative">
                        <div class="glass-orb"></div>
                        <h6 class="fw-bold mb-3 d-flex align-items-center">
                            <i class="bi bi-lightbulb-fill me-2 text-warning"></i>
                            Design Guidelines
                        </h6>
                        <ul class="list-unstyled small mb-0">
                            <li class="mb-2 d-flex gap-2">
                                <i class="bi bi-check2-circle text-warning"></i>
                                Ensure clear, unambiguous language.
                            </li>
                            <li class="mb-2 d-flex gap-2">
                                <i class="bi bi-check2-circle text-warning"></i>
                                Include relevant diagrams via editor.
                            </li>
                            <li class="d-flex gap-2">
                                <i class="bi bi-check2-circle text-warning"></i>
                                Map to exact lesson for better analytics.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification system for errors -->
    <div x-data="{ show: false, message: '', type: 'success' }"
         x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type; setTimeout(() => show = false, 5000)"
         class="position-fixed top-0 end-0 p-4" style="z-index: 10000">
        <div x-show="show" x-transition.duration.300ms
             :class="type === 'success' ? 'bg-success' : 'bg-danger'"
             class="text-white px-4 py-3 rounded-4 shadow-lg border-0 d-flex align-items-center gap-3">
            <i class="bi" :class="type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill'"></i>
            <span x-text="message" class="fw-bold"></span>
        </div>
    </div>

    @once
    <script src="{{ asset('js/ckeditor.js') }}"></script>
    <script>
        document.addEventListener('livewire:init', () => {
             const initCK = (selector, modelName) => {
                if(!window.CKEDITOR) {
                    console.error('CKEDITOR not found. Retrying in 500ms...');
                    setTimeout(() => initCK(selector, modelName), 500);
                    return;
                }
                if (CKEDITOR.instances[selector]) return;

                const editor = CKEDITOR.replace(selector, {
                    removePlugins: 'elementspath',
                    resize_enabled: false,
                    height: selector.includes('ans') ? 100 : 200,
                    toolbarGroups: [
                        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
                        { name: 'insert', groups: [ 'insert' ] },
                        { name: 'styles', groups: [ 'styles' ] },
                    ]
                });

                editor.on('change', () => {
                    @this.set(modelName, editor.getData());
                });

                // Sync from Livewire
                Livewire.on('editor-sync-' + modelName, (event) => {
                    const data = Array.isArray(event) ? event[0].data : event.data;
                    if (editor.getData() !== data) {
                        editor.setData(data);
                    }
                });
            };

            const autoInit = () => {
                document.querySelectorAll('.ckeditor-instance').forEach(el => {
                    if (!CKEDITOR.instances[el.id]) {
                        initCK(el.id, el.dataset.model);
                    }
                });
            };

            // Initial global init for all instances
            autoInit();

            // Watch for MCQ count changes to init new editors
            Livewire.on('mcq-updated', () => {
                setTimeout(autoInit, 100);
            });
        });
    </script>
    <style>
        .ls-1 { letter-spacing: 0.05em; }
        .x-small { font-size: 0.75rem; }
        .transition-all { transition: all 0.3s ease; }
        .hover-translate-y:hover { transform: translateY(-2px); }
        .hover-glow:hover { box-shadow: 0 0 15px rgba(var(--bs-primary-rgb), 0.4); }
        .custom-select { border: none; background-color: #f8f9fa; border-radius: 12px; padding: 0.75rem 1rem; }
        .form-range::-webkit-slider-thumb { background: var(--bs-primary); }
        .custom-radio { width: 1.25rem; height: 1.25rem; border: 2px solid #dee2e6; }
        .custom-radio:checked { background-color: #28a745; border-color: #28a745; }
        .glass-orb { position: absolute; top: -50px; right: -50px; width: 150px; height: 150px; background: rgba(255,255,255,0.1); border-radius: 50%; blur: 40px; }
        .editor-wrap { background: #fff; }
        .cke_chrome { border: none !important; box-shadow: none !important; }
        .cke_top { background: #f8f9fa !important; border-bottom: 1px solid #eee !important; }
    </style>
    @endonce
</div>
