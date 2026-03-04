@extends('Layouts.student')

@section('css')
<style>
    .package-section {
        margin-bottom: 2.5rem;
    }
    .package-section-title {
        font-weight: 700;
        font-size: 1.25rem;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: #1a1a1a;
    }
    .package-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    .content-card {
        background: #fff;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        padding: 1.25rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
    }
    .content-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 20px -8px rgba(0, 0, 0, 0.1);
        border-color: #3b82f6;
    }
    .card-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        font-size: 1.25rem;
    }
    .icon-test { background: #eff6ff; color: #3b82f6; }
    .icon-material { background: #fef2f2; color: #ef4444; }
    .icon-video { background: #fff7ed; color: #f59e0b; }
    .icon-gk { background: #f0fdf4; color: #10b981; }

    .card-title {
        font-weight: 600;
        font-size: 1.05rem;
        color: #111827;
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }
    .card-meta {
        font-size: 0.875rem;
        color: #6b7280;
        margin-bottom: 1.25rem;
    }
    .card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 1rem;
        border-top: 1px solid #f3f4f6;
        background: transparent;
    }
    .badge-premium {
        padding: 0.35rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    .btn-action {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .btn-primary-soft {
        background: #3b82f6;
        color: #fff;
        border: none;
    }
    .btn-primary-soft:hover {
        background: #2563eb;
        color: #fff;
    }
    .btn-outline-soft {
        background: transparent;
        border: 1px solid #d1d5db;
        color: #374151;
    }
    .btn-outline-soft:hover {
        background: #f9fafb;
        border-color: #9ca3af;
    }
    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #9ca3af;
        background: #f9fafb;
        border-radius: 12px;
        border: 2px dashed #e5e7eb;
    }
</style>
@endsection

@section('main')
<div class="container-fluid py-4">

    {{-- Tests Section --}}
    <div class="package-section">
        <h3 class="package-section-title">
            <div class="card-icon icon-test shadow-sm"><i class="bi bi-journal-text"></i></div>
            Tests & Assessments
        </h3>
        @if(count($test) > 0)
        <div class="package-grid">
            @foreach ($test as $onetest)
            <div class="content-card">
                <div>
                    <div class="card-title">{{ $onetest->title }}</div>
                    <div class="card-meta">
                        <div><i class="bi bi-layers me-1"></i> {{ $onetest->class_name }}</div>
                        <div><i class="bi bi-question-circle me-1"></i> {{ $onetest->total_questions }} Questions</div>
                    </div>
                </div>
                <div class="card-footer">
                    <span class="badge bg-light text-dark border">{{ date('d M Y', strtotime($onetest->created_at)) }}</span>
                    <a href="{{ route('student.test-name', [$onetest->id]) }}" class="btn-action btn-primary-soft">
                        <i class="bi bi-play-fill"></i> Start Test
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-state">No tests available in this package.</div>
        @endif
    </div>

    {{-- Study materials Section --}}
    <div class="package-section">
        <h3 class="package-section-title">
            <div class="card-icon icon-material shadow-sm"><i class="bi bi-file-earmark-pdf"></i></div>
            Study Notes & E-Books
        </h3>
        @if(count($study_material) > 0)
        <div class="package-grid">
            @foreach ($study_material as $onematerial)
            <div class="content-card">
                <div>
                    <div class="card-title">{{ $onematerial->title }}</div>
                    <p class="card-meta text-truncate">{{ $onematerial->sub_title }}</p>
                    <div class="card-meta">
                        <i class="bi bi-person-circle me-1"></i>
                        {{ $onematerial->institute_id == 0 ? 'Test and Notes' : (auth()->user()->myInstitute?->institute_name ?? 'Institute') }}
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex gap-2">
                        <a href="{{ url('storage/' . $onematerial->file) }}" target="_blank" class="btn-action btn-outline-soft">
                            <i class="bi bi-eye"></i> View
                        </a>
                        <a href="{{ url('storage/' . $onematerial->file) }}" download class="btn-action btn-outline-soft">
                            <i class="bi bi-download"></i>
                        </a>
                    </div>
                    <span class="badge rounded-pill bg-success-soft text-success border-success" style="background:#f0fdf4">{{ $onematerial->publish_status }}</span>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-state">No study materials available.</div>
        @endif
    </div>

    {{-- Videos Section --}}
    <div class="package-section">
        <h3 class="package-section-title">
            <div class="card-icon icon-video shadow-sm"><i class="bi bi-camera-video"></i></div>
            Live & Video Classes
        </h3>
        @if(count($live_video) > 0)
        <div class="package-grid">
            @foreach ($live_video as $onevideo)
            @if($onevideo)
            <div class="content-card">
                <div>
                    <div class="card-title">{{ $onevideo->title ?? 'Untitled Video' }}</div>
                    <p class="card-meta text-truncate">{{ $onevideo->sub_title ?? '' }}</p>
                </div>
                <div class="card-footer">
                    @if($onevideo->file == 'NA')
                        <a href="{{ $onevideo->video_link }}" target="_blank" class="btn-action btn-primary-soft w-100 justify-content-center">
                            <i class="bi bi-play-circle"></i> Watch Video
                        </a>
                    @else
                        <div class="d-flex gap-2 w-100">
                            <a href="{{ url('storage/' . $onevideo->file) }}" target="_blank" class="btn-action btn-outline-soft grow">
                                <i class="bi bi-eye"></i> View
                            </a>
                            <a href="{{ url('storage/' . $onevideo->file) }}" download class="btn-action btn-outline-soft">
                                <i class="bi bi-download"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            @endif
            @endforeach
        </div>
        @else
        <div class="empty-state">No video classes available.</div>
        @endif
    </div>

    {{-- GK Section --}}
    <div class="package-section">
        <h3 class="package-section-title">
            <div class="card-icon icon-gk shadow-sm"><i class="bi bi-globe"></i></div>
            Static GK & Current Affairs
        </h3>
        @if(count($onegk) > 0)
        <div class="package-grid">
            @foreach ($onegk as $one_gk)
            @if($one_gk)
            <div class="content-card">
                <div>
                    <div class="card-title">{{ $one_gk->title }}</div>
                    <p class="card-meta text-truncate">{{ $one_gk->sub_title }}</p>
                </div>
                <div class="card-footer">
                    @if($one_gk->file == 'NA')
                        <span class="text-muted small">Content not available</span>
                    @else
                        <div class="d-flex gap-2 w-100">
                            <a href="{{ url('storage/' . $one_gk->file) }}" target="_blank" class="btn-action btn-outline-soft grow">
                                <i class="bi bi-eye"></i> View
                            </a>
                            <a href="{{ url('storage/' . $one_gk->file) }}" download class="btn-action btn-outline-soft">
                                <i class="bi bi-download"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            @endif
            @endforeach
        </div>
        @else
        <div class="empty-state">No GK content available.</div>
        @endif
    </div>

</div>
@endsection
