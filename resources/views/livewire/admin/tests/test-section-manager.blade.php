<div class="container-fluid py-4">
    {{-- Heading is handled by Layouts.admin --}}

    <div class="row g-4">
        <div class="col-md-9">
            <div class="sections-container d-flex flex-column gap-4">
                @foreach($sectionKeys as $index => $item)
                    <div wire:key="{{ $item['key'] }}">
                        @livewire('admin.tests.test-section-row', [
                            'index' => $index,
                            'testId' => $testId,
                            'sectionId' => $item['id'],
                            'subjects' => $allSubjects,
                            'creators' => $allCreators,
                            'publishers' => $allPublishers
                        ], key($item['key']))
                    </div>
                @endforeach
            </div>

            <div class="mt-5 pt-3 border-top d-flex justify-content-end gap-3">
                <button wire:click="saveAll" class="btn btn-success btn-lg px-5">
                    <span wire:loading wire:target="saveAll" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                    <span wire:loading.remove wire:target="saveAll">Save All Sections</span>
                    <span wire:loading wire:target="saveAll">Saving...</span>
                </button>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border shadow-sm sticky-top" style="top: 80px;">
                <div class="card-body p-3">
                    <h6 class="fw-bold mb-3 text-muted small text-uppercase">Test Overview</h6>

                    <div class="d-flex flex-wrap gap-2 mb-0">
                        <span class="badge border border-primary text-primary fw-normal px-2 py-2 bg-light">{{ $test->Educationtype->name ?? 'N/A' }}</span>
                        <span class="badge border border-primary text-primary fw-normal px-2 py-2 bg-light">{{ $test->EducationClass->name ?? 'N/A' }}</span>
                        @if($test->EducationBoard)
                            <span class="badge border border-primary text-primary fw-normal px-2 py-2 bg-light">{{ $test->EducationBoard->name }}</span>
                        @endif
                        @if($test->gn_OtherCategoryClass)
                            <span class="badge border border-primary text-primary fw-normal px-2 py-2 bg-light">{{ $test->gn_OtherCategoryClass->name }}</span>
                        @endif
                        <hr style="width: 100%;" />
                        <span class="badge border border-info text-info fw-normal px-2 py-2 bg-light">{{ $test->gn_marks_per_questions }} Marks / Question</span>
                        <span class="badge border border-danger text-danger fw-normal px-2 py-2 bg-light">{{ $test->negative_marks }}% Negative</span>
                        <span class="badge border border-dark text-dark fw-normal px-2 py-2 bg-light">{{ $test->sections }} Sections</span>
                        <span class="badge border border-dark text-dark fw-normal px-2 py-2 bg-light">Total {{ $test->total_questions }} Questions</span>
                    </div>

                    <div class="alert alert-info py-2 px-3 mt-4 mb-0 small border-0">
                        <i class="bi bi-info-circle me-1"></i>
                        Configure details for each section below.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
