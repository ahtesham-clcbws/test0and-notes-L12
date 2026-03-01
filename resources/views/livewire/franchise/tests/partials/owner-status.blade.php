@php
    $total_questions = $test->total_questions;
    $qCount = $test->questions_count;
    $sections = $test->getSection;
    $publish_count = $sections->where('is_published', 1)->count();
    $creater_count = $sections->where('sent_to_publisher', 1)->count();

    // Admin/Staff specifics if needed
    $current_auth_id = \Illuminate\Support\Facades\Auth::id();
    $admin_publish_count = $sections->where('publisher_id', $current_auth_id)->where('is_published', 1)->count();
    $admin_creater_count = $sections->where('creator_id', $current_auth_id)->where('sent_to_publisher', 1)->count();
@endphp

@if($total_questions == 0)
    <span class="badge bg-warning text-dark">Awaiting Sections</span>
@else
    @if($total_questions != $qCount)
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
        @endif

        @if($admin_publish_count > 0 || $admin_creater_count > 0)
            @if($admin_publish_count == $test->sections && $admin_creater_count == $test->sections)
                <a href="{{ $this->getRoute('dashboard_publish_test_exam', [$test->id]) }}"><span class="badge bg-primary">Publish Test</span></a>
            @endif
        @else
            @if($creater_count != $test->sections && $publish_count != $test->sections)
                <span class="badge bg-warning text-dark">Created</span>
            @elseif($creater_count == $test->sections && $publish_count != $test->sections)
                <span class="badge bg-warning text-dark">Awaiting Publisher</span>
            @elseif($creater_count == $test->sections && $publish_count == $test->sections)
                @if($test->published != 1)
                    <a href="{{ $this->getRoute('dashboard_publish_test_exam', [$test->id]) }}"><span class="badge bg-primary">Publish Test</span></a>
                @endif
            @endif
        @endif

        @if($test->published == 1)
            <a href="{{ $this->getRoute('dashboard_publish_test_exam', [$test->id]) }}"><span class="badge bg-success">Published</span></a>
        @endif
    @endif
@endif
