<div class="container-fluid pb-5 h-100 d-flex flex-column align-items-center justify-content-center"
     style="min-height: 80vh;"
     x-data="{ isDragging: false }">

    <div class="card border-0 shadow-lg rounded-4 overflow-hidden animate__animated animate__zoomIn" style="max-width: 600px; width: 100%;">
        <div class="card-body p-5">
            <div class="text-center mb-5">
                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4 p-4 shadow-sm">
                    <i class="bi bi-file-earmark-spreadsheet-fill text-primary fs-1"></i>
                </div>
                <h3 class="fw-bold text-dark">Mass Integration</h3>
                <p class="text-muted">Import architectural blueprints of questions via Excel/CSV</p>
            </div>

            <div
                class="upload-zone rounded-4 border-2 border-dashed p-5 text-center transition-all bg-light"
                :class="isDragging ? 'border-primary bg-primary bg-opacity-10 scale-102 shadow-glow' : 'border-muted opacity-80'"
                @dragover.prevent="isDragging = true"
                @dragleave.prevent="isDragging = false"
                @drop.prevent="isDragging = false; $refs.fileInput.files = $event.dataTransfer.files; $refs.fileInput.dispatchEvent(new Event('change'))"
                @click="$refs.fileInput.click()">

                <input type="file" wire:model="file" x-ref="fileInput" class="d-none" accept=".xlsx,.xls,.csv">

                <div wire:loading.remove wire:target="file">
                    <i class="bi bi-cloud-arrow-up text-primary fs-huge display-4 mb-3 d-block"></i>
                    <h6 class="fw-bold mb-2">Click or Drag & Drop</h6>
                    <span class="text-muted small">Supports .xlsx, .xls, .csv (Max 10MB)</span>
                </div>

                <div wire:loading wire:target="file">
                    <div class="spinner-grow text-primary mb-3" role="status"></div>
                    <h6 class="fw-bold mb-2">Analyzing Architecture...</h6>
                    <span class="text-muted small">Uploading encrypted data stream</span>
                </div>

                @if($file)
                    <div class="mt-4 animate__animated animate__fadeIn">
                        <div class="d-flex align-items-center justify-content-center gap-3 bg-white p-3 rounded-3 shadow-sm border">
                            <i class="bi bi-file-check-fill text-success fs-4"></i>
                            <div class="text-start">
                                <span class="fw-bold d-block text-truncate" style="max-width: 250px">{{ $file->getClientOriginalName() }}</span>
                                <small class="text-muted">{{ number_format($file->getSize() / 1024 / 1024, 2) }} MB</small>
                            </div>
                            <button type="button" @click.stop class="btn btn-sm btn-outline-danger border-0 rounded-circle" wire:click="$set('file', null)">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>
                @endif
            </div>

            <div class="mt-5 d-grid gap-3">
                <button
                    wire:click="import"
                    class="btn btn-primary btn-lg rounded-3 py-3 fw-bold shadow-lg transition-all hover-glow"
                    @disabled(!$file || $isImporting)>
                    <span wire:loading.remove wire:target="import">
                        <i class="bi bi-rocket-takeoff me-2"></i>Execute Import Strategy
                    </span>
                    <span wire:loading wire:target="import">
                        <span class="spinner-border spinner-border-sm me-2"></span>Integrating Records...
                    </span>
                </button>
                <a href="{{ route('administrator.dashboard_question_list') }}" class="btn btn-light border-0 py-2 text-muted fw-semi-bold">
                    Abort Mission
                </a>
            </div>

            <div class="mt-5 pt-4 border-top border-opacity-10 text-center">
                <a href="#" class="text-decoration-none small text-muted hover-primary transition-all">
                    <i class="bi bi-download me-2"></i>Download Reference Schema Blueprint
                </a>
            </div>
        </div>
    </div>

    <!-- Notification system for errors -->
    <div x-data="{ show: false, message: '', type: 'success' }"
         x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type; setTimeout(() => show = false, 5000)"
         class="position-fixed top-0 end-0 p-4" style="z-index: 10000">
        <div x-show="show" x-transition.duration.300ms
             :class="type === 'success' ? 'bg-success shadow-success' : 'bg-danger shadow-danger'"
             class="text-white px-4 py-3 rounded-4 shadow-lg border-0 d-flex align-items-center gap-3">
            <i class="bi" :class="type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill'"></i>
            <span x-text="message" class="fw-bold"></span>
        </div>
    </div>

    <style>
        .scale-102 { transform: scale(1.02); }
        .shadow-glow { box-shadow: 0 0 25px rgba(var(--bs-primary-rgb), 0.2); }
        .transition-all { transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); }
        .upload-zone { cursor: pointer; border-style: dashed; }
        .hover-glow:hover:not(:disabled) { box-shadow: 0 0 20px rgba(var(--bs-primary-rgb), 0.5); transform: translateY(-2px); }
        .fs-huge { font-size: 5rem; }
    </style>
</div>
