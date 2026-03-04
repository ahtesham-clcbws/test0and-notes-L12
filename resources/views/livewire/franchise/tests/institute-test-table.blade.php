<div>
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="row mb-4">
        <div class="col-md-4">
            <input type="text" class="form-control" placeholder="Search tests..." wire:model.live.debounce.300ms="search">
        </div>
        @if($viewMode === 'owner')
        <div class="col-md-3">
            <select class="form-select" wire:model.live="test_cat">
                <option value="">All Categories</option>
                @foreach(\DB::table('test_cat')->get() as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->cat_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select class="form-select" wire:model.live="published">
                <option value="">All Status</option>
                <option value="true">Published</option>
                <option value="false">Unpublished</option>
            </select>
        </div>
        @endif
        <div class="col-md-2 text-end">
             <div wire:loading class="spinner-border spinner-border-sm text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th scope="col">Test</th>
                        <th scope="col">Education / Class</th>
                        @if($viewMode === 'owner')
                            <th scope="col">Category</th>
                            <th scope="col">Created By/Date</th>
                            <th scope="col">Sections</th>
                            <th scope="col">Type / Fees</th>
                        @else
                            <th scope="col">Created By/Date</th>
                            <th scope="col">Questions</th>
                        @endif
                        <th scope="col">Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($results as $item)
                        @php
                            $test = ($viewMode === 'owner') ? $item : $item->test;
                        @endphp
                        <tr>
                            <td>
                                <strong>{{ ($viewMode === 'owner') ? $item->title : $item->test_title }}</strong>
                                @if($viewMode !== 'owner')
                                    <div class="small text-muted">Section ID: {{ $item->id }}</div>
                                @endif
                            </td>
                            <td>
                                <div>{{ optional($test->Educationtype)->name }}</div>
                                <div class="small text-muted">{{ optional($test->EducationClass)->name }}</div>
                            </td>

                            @if($viewMode === 'owner')
                                <td>{{ optional($item->getTestCat)->cat_name }}</td>
                                <td>
                                    <div>{{ \Illuminate\Support\Facades\Auth::user()->name }}</div>
                                    <div class="small text-muted">{{ $item->created_at->format('d-m-Y') }}</div>
                                </td>
                                @if($viewMode === 'owner')
                                    @php
                                        $sections = $item->getSection;
                                    @endphp
                                    @if($sections->count() > 0)
                                        @foreach($sections as $idx => $sec)
                                            <a href="{{ $this->getRoute('dashboard_test_section_question', [$item->id, $sec->id]) }}"
                                               title="Section {{ $idx + 1 }} Questions"
                                               class="me-1">
                                                <i class="bi bi-journal-text text-primary"></i>
                                            </a>
                                        @endforeach
                                    @else
                                        <span class="text-muted">0 Sections</span>
                                    @endif
                                @else
                                    <a href="{{ $this->getRoute('dashboard_test_section_question', [$test->id, $item->id]) }}"
                                       title="Manage Section Questions"
                                       class="btn btn-sm btn-outline-primary">
                                       <i class="bi bi-journal-text"></i>
                                    </a>
                                @endif
                            </td>
                            <td>
                                <div>{{ $item->test_type == 1 ? 'Free' : 'Premium' }}</div>
                                @if($item->test_type == 0 || $item->test_type == 3)
                                    <div class="small text-muted">₹ {{ $item->price }}</div>
                                @endif
                            </td>
                        @else
                            <td>
                                <div>{{ $item->owner_name }}</div>
                                <div class="small text-muted">{{ \Carbon\Carbon::parse($item->test_created_at)->format('d-m-Y') }}</div>
                            </td>
                            <td>
                                {{ $item->number_of_questions }} / {{ $item->questions_count }}
                            </td>
                        @endif

                        <td>
                            @if($viewMode === 'owner')
                                @include('livewire.franchise.tests.partials.owner-status', ['test' => $item])
                            @else
                                @include('livewire.franchise.tests.partials.staff-status', ['section' => $item, 'test' => $test])
                            @endif
                        </td>
                        <td class="text-end">
                            @if($viewMode === 'owner')
                                <a href="{{ $this->getRoute('dashboard_update_test_exam', [$item->id]) }}" class="btn btn-sm btn-outline-success" title="Edit Test">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button wire:click="deleteTest({{ $item->id }})"
                                        wire:confirm="Are you sure you want to delete this test?"
                                        class="btn btn-sm btn-outline-danger" title="Delete Test">
                                    <i class="bi bi-trash"></i>
                                </button>
                            @else
                                <a href="{{ $this->getRoute('dashboard_update_test_exam', [$test->id]) }}" class="btn btn-sm btn-outline-success" title="Edit Test">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-4 text-muted">No tests found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($results->hasPages())
            <div class="card-footer">
                {{ $results->links() }}
            </div>
        @endif
    </div>
</div>
