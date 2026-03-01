<div class="card border mb-4 shadow-sm">
    <div class="card-header bg-light border-bottom py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 text-primary fw-bold">
            <span class="badge bg-primary me-2">Section {{ $index + 1 }}</span>
        </h6>
        <div class="d-flex gap-2">
            {{-- Save moved to bottom --}}
        </div>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <!-- Row 1 -->
            <div class="col-md-3">
                <label class="form-label small fw-bold">Main Subject</label>
                <select wire:model.live="subject_id" class="form-select form-select-sm">
                    <option value="">Select Subject</option>
                    @foreach($subjects as $s)
                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                    @endforeach
                </select>
                @error('subject_id') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold">Subject Part</label>
                <select wire:model.live="part_id" class="form-select form-select-sm" @disabled(!$subject_id)>
                    <option value="">Select Part</option>
                    @foreach($parts as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold">Chapter/Lesson</label>
                <select wire:model.live="chapter_id" class="form-select form-select-sm" @disabled(!$part_id)>
                    <option value="">Select Chapter</option>
                    @foreach($chapters as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold">Difficulty Level</label>
                <select wire:model="difficulty_level" class="form-select form-select-sm">
                    @foreach([25, 35, 40, 50, 60, 70, 75, 80, 90, 100] as $val)
                        <option value="{{ $val }}">{{ $val }}%</option>
                    @endforeach
                </select>
                @error('difficulty_level') <span class="text-danger small d-block">{{ $message }}</span> @enderror
            </div>

            <!-- Row 2 -->
            <div class="col-md-3">
                <label class="form-label small fw-bold">Type of Questions</label>
                <select wire:model.live="question_type" class="form-select form-select-sm">
                    <option value="1">MCQ</option>
                    <option value="2">Subjective</option>
                </select>
                @error('question_type') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold">No of options</label>
                <select wire:model="mcq_options" class="form-select form-select-sm" {{ $question_type != 1 ? 'disabled' : '' }}>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold">No of questions</label>
                <input type="number" wire:model.blur="number_of_questions" class="form-control form-control-sm" min="1">
                @error('number_of_questions') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold">Duration (per Question)</label>
                <select wire:model="duration" class="form-select form-select-sm">
                    @for($i=1; $i<=10; $i++)
                        <option value="{{ $i }}">{{ $i }} Minutes</option>
                    @endfor
                </select>
            </div>
            <!-- Row 3 -->
            <div class="col-md-3">
                <label class="form-label small fw-bold">Test Creator</label>
                <select wire:model="creator_id" class="form-select form-select-sm">
                    <option value="">Select Creator</option>
                    @foreach($creators as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold">Test Submission Date</label>
                <input type="date" wire:model="date_of_completion" class="form-control form-control-sm">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold">Test Publisher</label>
                <select wire:model="publisher_id" class="form-select form-select-sm">
                    <option value="">Select Publisher</option>
                    @foreach($publishers as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold">Test Publishing Date</label>
                <input type="date" wire:model="publishing_date" class="form-control form-control-sm">
            </div>
            <!-- Row 4 -->
            <div class="col-md-12">
                <label class="form-label small fw-bold">Instruction/Notes</label>
                <textarea wire:model="section_instruction" class="form-control form-control-sm" rows="3" placeholder="Enter instructions or notes..."></textarea>
            </div>

            <div class="col-12 mt-3">
                <button wire:click="save" class="btn btn-success btn-sm px-4">
                    <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                    <span wire:loading.remove wire:target="save">Submit Request</span>
                    <span wire:loading wire:target="save">Saving...</span>
                </button>
            </div>

            <!-- Alpine Notification Component for this Section -->
            <div x-data="{ show: false, message: '', type: 'success' }"
                 x-on:notify.window="if ($event.detail.type) { show = true; message = $event.detail.message; type = $event.detail.type; setTimeout(() => { show = false }, 3000) }"
                 class="col-12 mt-2"
                 style="display: none;"
                 x-show="show"
                 x-transition>
                <div :class="{ 'alert-success': type === 'success', 'alert-danger': type === 'error' }" class="alert py-2 px-3 mb-0 small" role="alert">
                    <span x-text="message"></span>
                </div>
            </div>
        </div>
    </div>
</div>
