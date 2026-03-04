<div>
    <div class="pb-4 d-flex justify-content-between align-items-center">
        <div class="col-4">
             <small><b>Search</b></small>
             <input type="text" class="form-control form-control-sm" placeholder="Search test title..." wire:model.live.debounce.300ms="search">
        </div>
    </div>

    <div class="dashboard-container mb-5">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Test</th>
                                <th>Class Name</th>
                                <th>Created Date</th>
                                <th>Questions</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tests as $test)
                                <tr>
                                    <td>{{ $test->title }}</td>
                                    <td>{{ $test->EducationClass->name ?? '' }}</td>
                                    <td>{{ $test->created_at ? $test->created_at->format('d-m-Y') : '' }}</td>
                                    <td>{{ $test->total_questions }} / {{ $test->confirmed_questions_count }}</td>
                                    <td class="text-end">
                                        @php
                                            $attempt = $test->testAttempts->first();
                                        @endphp

                                        @if (!$attempt)
                                            <a class="btn btn-sm btn-info" href="{{ route('student.test-name', [$test->id]) }}" title="Start Test">
                                                <i class="bi bi-pencil-square me-2"></i>Start Test
                                            </a>
                                        @else
                                            <a class="btn btn-sm btn-secondary" href="javascript:void(0)" onClick="alert('Test Already submitted')" title="Test Submitted">
                                                <i class="bi bi-check-circle me-2"></i>Submitted
                                            </a>
                                            <a class="btn btn-sm btn-outline-info" href="{{ route('student.show-result', [Auth::user()->id, $test->id]) }}">
                                                View Result
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No tests found for your education type.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $tests->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
