<div>
    <div class="pb-4 d-flex justify-content-between align-items-end">
        <div class="col-2">
            <small><b>Published Status</b></small>
            <select class="form-select form-select-sm" wire:model.live="published">
                <option value="">All</option>
                <option value="true">Published</option>
                <option value="false">Not Published</option>
            </select>
        </div>
        <div class="col-3">
             <small><b>Search</b></small>
             <input type="text" class="form-select form-select-sm" placeholder="Search test title..." wire:model.live.debounce.300ms="search">
        </div>
        <div class="text-end">
            <div class="btn-group" role="group" id="test_cat_button">
                <button type="button" wire:click="setCategory('')" class="btn btn-outline-primary {{ $test_cat === '' ? 'active' : '' }}">All Test</button>
                <button type="button" wire:click="setCategory('4')" class="btn btn-outline-primary {{ $test_cat === '4' ? 'active' : '' }}">New Test</button>
                <button type="button" wire:click="setCategory('5')" class="btn btn-outline-primary {{ $test_cat === '5' ? 'active' : '' }}">Original Test</button>
                <button type="button" wire:click="setCategory('6')" class="btn btn-outline-primary {{ $test_cat === '6' ? 'active' : '' }}">Previous Test</button>
                <button type="button" wire:click="setCategory('7')" class="btn btn-outline-primary {{ $test_cat === '7' ? 'active' : '' }}">Premium Test</button>
            </div>
        </div>
    </div>

    <div class="dashboard-container mb-5">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Test title</th>
                                <th>Education Type / Class Group</th>
                                <th>Test Category</th>
                                <th>Created By / Date</th>
                                <th>Sections</th>
                                <th>Test Type</th>
                                <th>Status</th>
                                <th>Featured</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tests as $test)
                                <tr>
                                    <td>{{ $test->title }}</td>
                                    <td>
                                        <div>{{ $test->Educationtype->name ?? '' }}</div>
                                        <div>{{ $test->EducationClass->name ?? '' }}</div>
                                    </td>
                                    <td>{{ $test->getTestCat->cat_name ?? '' }}</td>
                                    <td>
                                        <div>{{ $test->institute_name ?? $test->username ?? 'Admin' }}</div>
                                        <div>{{ $test->created_at ? $test->created_at->format('d-m-Y') : '' }}</div>
                                    </td>
                                    <td>
                                        <div>
                                            @if($test->testSections)
                                                @foreach($test->testSections as $index => $section)
                                                    @if ($section->subject && $section->subject_part && $section->subject_part_lesson && $section->number_of_questions)
                                                        <a href="{{ route('administrator.dashboard_test_section_question', [$test->id, $section->id]) }}" title="Section {{ $index + 1 }} Questions">
                                                            <i class="bi bi-journal-text text-primary me-2"></i>
                                                        </a>
                                                    @else
                                                        <a href="javascript:void(0)" onclick="alert('Please Add section detail before adding questions.')">
                                                            <i class="bi bi-journal-text text-primary me-2"></i>
                                                        </a>
                                                    @endif
                                                @endforeach
                                            @else
                                                0 Sections
                                            @endif
                                        </div>
                                        <div>{{ $test->total_questions }} / {{ $test->confirmed_questions_count }}</div>
                                    </td>
                                    <td>
                                        <div>{{ $test->test_type == 1 ? 'Free' : 'Premium' }}</div>
                                        <div>{{ $test->price }} {{ in_array($test->test_type, [0, 3]) ? '₹' : '' }}</div>
                                    </td>
                                    <td>
                                        @if ($test->total_questions == 0)
                                            <span class="badge bg-warning text-dark">Awaiting Sections</span>
                                        @elseif ($test->total_questions != $test->confirmed_questions_count)
                                            <span class="badge bg-warning text-dark">Awaiting Questions</span>
                                        @elseif ($test->published == 1)
                                            <a href="{{ route('administrator.dashboard_publish_test_exam', [$test->id]) }}">
                                                <span class="badge bg-success">Published</span>
                                            </a>
                                        @elseif ($test->reviewed)
                                            @php
                                                $badgeClass = match($test->reviewed_status) {
                                                    'approved' => 'bg-success',
                                                    'rejected' => 'bg-danger',
                                                    'onhold' => 'bg-warning text-dark',
                                                    default => 'bg-primary'
                                                };
                                                $statusText = match($test->reviewed_status) {
                                                    'approved' => 'Approved',
                                                    'rejected' => 'Rejected',
                                                    'onhold' => 'Hold Review',
                                                    default => 'Under Review'
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">{{ $statusText }}</span>
                                        @else
                                            <a href="{{ route('administrator.dashboard_publish_test_exam', [$test->id]) }}">
                                                <span class="badge bg-primary">Publish Test</span>
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if($test->published == 1)
                                            <button wire:click="toggleFeatured({{ $test->id }})" class="btn btn-sm {{ $test->featured == 1 ? 'btn-success' : 'btn-warning' }}">
                                                {{ $test->featured == 1 ? 'Featured' : 'UnFeatured' }}
                                            </button>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('administrator.dashboard_update_test_exam', [$test->id]) }}" title="Edit Test">
                                            <i class="bi bi-pencil-square text-success me-2"></i>
                                        </a>
                                        <a href="javascript:void(0);" wire:click="deleteTest({{ $test->id }})" wire:confirm="Are you sure you want to delete this test?" title="Delete Test">
                                            <i class="bi bi-trash2-fill text-danger me-2"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No tests found.</td>
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
