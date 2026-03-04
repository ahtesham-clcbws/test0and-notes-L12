@php
    $total_questions = $section->number_of_questions;
    $qCount = $section->questions_count;
    $parentTest = $section->test;

    // For manager role, we sometimes need overall test stats
    $allSections = $parentTest->getSection;
    $publish_count = $allSections->where('is_published', 1)->count();
    $creater_count = $allSections->where('sent_to_publisher', 1)->count();
@endphp

@if($total_questions == 0)
    <span class="badge bg-warning text-dark">Awaiting Sections</span>
@elseif($total_questions != $qCount)
    <span class="badge bg-warning text-dark">Awaiting Questions</span>
@else
    @if($test->reviewed)
        @if($test->reviewed_status == 'approved')
            <span class="badge bg-success">Approved</span>
        @elseif($test->reviewed_status == 'rejected')
            <span class="badge bg-danger">Rejected</span>
        @elseif($test->reviewed_status == 'onhold')
            <span class="badge bg-warning text-dark">Hold Review</span>
        @endif
    @elseif($viewMode === 'manager')
        @if ($creater_count != $parentTest->sections && $publish_count != $parentTest->sections)
            <span class="badge bg-warning text-dark">Created</span>
        @elseif ($creater_count == $parentTest->sections && $publish_count != $parentTest->sections)
            <span class="badge bg-warning text-dark">Awaiting Publisher</span>
        @elseif ($creater_count == $parentTest->sections && $publish_count == $parentTest->sections)
            @if($parentTest->published != 1)
                <a href="{{ $this->getRoute('dashboard_publish_test_exam', [$parentTest->id]) }}"><span class="badge bg-primary">Publish Test</span></a>
            @endif
        @endif
    @endif

    {{-- Individual Section Status --}}
    @if($section->sent_to_publisher == 1)
        @if($viewMode === 'publisher')
             <button wire:click="publishSection({{ $section->id }})" class="badge bg-primary border-0">Publish Section</button>
        @else
             <span class="badge bg-primary">Waiting for Approval</span>
        @endif
    @else
        <button wire:click="sentToPublisher({{ $section->id }})" class="badge bg-primary border-0">Sent to Publisher</button>
    @endif

    @if($section->is_published == 1)
        <span class="badge bg-success">Published</span>
    @endif

    @if($parentTest->published == 1)
        <span class="badge bg-success ms-1">Test Published</span>
    @endif
@endif
