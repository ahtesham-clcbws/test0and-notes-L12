<div>
    {{-- Test Header Banner --}}
    <div class="card mb-3 border-0 shadow-sm" style="border-radius: 8px;">
        <div class="card-body bg-success text-white rounded-3 p-3">
            <h4 class="mb-1 text-white">{{ $test->title ?? 'Online Test' }}</h4>
            <div class="small text-white-50">
                <i class="bi bi-calendar-check me-1"></i> Completed & Evaluated
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Sidebar Score Panel --}}
        <div class="col-lg-4 col-md-12 mb-3">
            <div class="border bg-white p-3 rounded-lg shadow-sm">
                <h4 class="text-center text-success mb-3">Test Result</h4>
                
                <div class="d-flex justify-content-between border-bottom py-2">
                    <span>Total Questions:</span>
                    <span class="fw-bold">{{ $test->total_questions ?? $total_question }}</span>
                </div>
                <div class="d-flex justify-content-between border-bottom py-2">
                    <span>Attempted:</span>
                    <span class="fw-bold text-success">{{ $total_question - $not_attempted }}</span>
                </div>
                <div class="d-flex justify-content-between border-bottom py-2">
                    <span>Not-Attempted:</span>
                    <span class="fw-bold text-secondary">{{ $not_attempted }}</span>
                </div>
                <div class="d-flex justify-content-between border-bottom py-2">
                    <span>Right Answers:</span>
                    <span class="fw-bold text-success">{{ $correct_answer }} (<span class="text-secondary">{{ $out_of_marks }} Marks</span>)</span>
                </div>
                <div class="d-flex justify-content-between border-bottom py-2">
                    <span>Wrong Answers:</span>
                    <span class="fw-bold text-danger">{{ $incorrect_answer }} (<span class="text-secondary">-{{ $negative_marks }} Marks</span>)</span>
                </div>
                <div class="d-flex justify-content-between py-2 border-top border-2 mt-2">
                    <span class="fw-bold fs-6">Final Marks:</span>
                    <span class="fw-bold fs-6 text-success">{{ $final_marks }}</span>
                </div>

                <div class="mt-3 d-grid gap-2">
                    {{-- Updated Dynamic Back buttons --}}
                    <a href="{{ route('student.dashboard_tests_list') }}" class="btn btn-outline-success">
                        <i class="ti-arrow-left me-1"></i> Back to Dashboard
                    </a>
                    <a href="/student/attempt" class="btn btn-success">
                        <i class="ti-list me-1"></i> View Attempts History
                    </a>
                </div>
            </div>
        </div>

        {{-- Detailed Question Responses / Solutions --}}
        <div class="col-lg-8 col-md-12">
            @if ($test->show_answer == 1)
                <div class="accordion" id="questionsAccordion">
                    @foreach ($test->testSections as $secIndex => $section)
                        <div class="mb-3">
                            <h5 class="p-2 bg-light rounded text-success fw-bold">{{ $section->sectionSubject->name }}</h5>
                            
                            @foreach ($section->getQuestions()->wherePivot('deleted_at', '=', null)->get() as $qIndex => $question)
                                @php
                                    // Calculate result state for this question item
                                    $response = \App\Models\Gn_Test_Response::where('student_id', $studentId)
                                        ->where('test_id', $testId)
                                        ->where('question_id', $question->id)
                                        ->first();
                                    
                                    $isCorrect = $response && $response->answer === $question->mcq_answer;
                                    $isUnattempted = !$response || $response->answer === null || $response->answer === '';
                                @endphp

                                <div class="card mb-2 border rounded-sm">
                                    <div class="card-header bg-white d-flex justify-content-between align-items-center p-2" style="cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#collapse_{{ $question->id }}">
                                        <span class="fw-bold">
                                            Question {{ $qIndex + 1 }}
                                            @if ($isUnattempted)
                                                <span class="badge bg-secondary ms-2">Not Attempted</span>
                                            @elseif ($isCorrect)
                                                <span class="badge bg-success ms-2">Correct</span>
                                            @else
                                                <span class="badge bg-danger ms-2">Incorrect</span>
                                            @endif
                                        </span>
                                        <i class="ti-angle-down"></i>
                                    </div>
                                    <div id="collapse_{{ $question->id }}" class="collapse show" data-bs-parent="#questionsAccordion">
                                        <div class="card-body p-3">
                                            <div class="mb-3">{!! $question->question !!}</div>

                                            <ul class="list-group">
                                                @for ($k = 1; $k <= $question->mcq_options; $k++)
                                                    @php 
                                                        $optKey = 'ans_' . $k;
                                                        $liClass = '';
                                                        
                                                        // Accurate background coloring for solutions review
                                                        if ($question->mcq_answer === $optKey) {
                                                            $liClass = 'list-group-item-success'; // Correct answer
                                                        } elseif ($response && $response->answer === $optKey && !$isCorrect) {
                                                            $liClass = 'list-group-item-danger'; // Selected wrong option
                                                        }
                                                    @endphp
                                                    <li class="list-group-item {{ $liClass }} p-2">
                                                        <span class="fw-bold">({{ chr(64 + $k) }})</span> {!! $question->$optKey !!}
                                                    </li>
                                                @endfor
                                            </ul>

                                            @if ($test->show_solution == 1)
                                                <div class="mt-3 p-2 bg-gray-50 rounded border">
                                                    @if ($question->solution)
                                                        <div><strong>Solution:</strong> {!! $question->solution !!}</div>
                                                    @endif
                                                    @if ($question->explanation)
                                                        <div class="mt-1 border-top pt-1"><strong>Explanation:</strong> {!! $question->explanation !!}</div>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info text-center">
                    <i class="ti-info-alt me-1"></i> Responses for this exam are currently locked by the administrator.
                </div>
            @endif
        </div>
    </div>
</div>
