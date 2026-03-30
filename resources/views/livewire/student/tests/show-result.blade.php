<div>
    <x-header title="{{ $test->title ?? 'Online Test' }}" subtitle="Completed & Evaluated" size="text-3xl" separator progress-indicator>
        <x-slot:actions>
            <x-button label="Back to Dashboard" icon="o-arrow-left" link="{{ route('student.dashboard_tests_list') }}" />
            <x-button label="View Attempts History" icon="o-list-bullet" link="/student/attempt" class="btn-primary" />
        </x-slot:actions>
    </x-header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
        {{-- Sidebar Score Panel --}}
        <div class="lg:col-span-1">
            <x-card title="Test Result" class="shadow-sm border border-base-200 bg-base-100 sticky top-4">
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center pb-3 border-b border-base-200">
                        <span class="text-base-content/70">Total Questions</span>
                        <span class="font-bold text-lg">{{ $test->total_questions ?? $total_question }}</span>
                    </div>

                    <div class="flex justify-between items-center pb-3 border-b border-base-200">
                        <span class="text-base-content/70">Attempted</span>
                        <x-badge value="{{ $total_question - $not_attempted }}" class="badge-success badge-lg font-bold" />
                    </div>

                    <div class="flex justify-between items-center pb-3 border-b border-base-200">
                        <span class="text-base-content/70">Not Attempted</span>
                        <x-badge value="{{ $not_attempted }}" class="badge-neutral badge-lg font-bold" />
                    </div>

                    <div class="flex justify-between items-center pb-3 border-b border-base-200">
                        <div>
                            <span class="text-success font-bold flex items-center gap-1"><x-icon name="o-check-circle" class="w-4 h-4" /> Right Answers</span>
                        </div>
                        <div class="text-right">
                            <span class="font-bold text-success">{{ $correct_answer }}</span>
                            <div class="text-xs text-base-content/50">{{ $out_of_marks }} Marks</div>
                        </div>
                    </div>

                    <div class="flex justify-between items-center pb-3 border-b border-base-200">
                        <div>
                            <span class="text-error font-bold flex items-center gap-1"><x-icon name="o-x-circle" class="w-4 h-4" /> Wrong Answers</span>
                        </div>
                        <div class="text-right">
                            <span class="font-bold text-error">{{ $incorrect_answer }}</span>
                            <div class="text-xs text-base-content/50">-{{ $negative_marks }} Marks</div>
                        </div>
                    </div>

                    <div class="flex justify-between items-center pt-2">
                        <span class="font-bold text-xl">Final Score</span>
                        <span class="font-bold text-4xl text-primary">{{ $final_marks }}</span>
                    </div>
                </div>
            </x-card>
        </div>

        {{-- Detailed Question Responses / Solutions --}}
        <div class="lg:col-span-2">
            @if ($test->show_answer == 1)
                @foreach ($test->testSections as $secIndex => $section)
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-primary mb-4 pb-2 border-b border-primary/20 flex items-center gap-2">
                            <x-icon name="o-rectangle-stack" class="w-7 h-7" />
                            {{ $section->sectionSubject->name }}
                        </h3>
                        
                        <div class="space-y-4">
                            @foreach ($section->getQuestions()->wherePivot('deleted_at', '=', null)->get() as $qIndex => $question)
                                @php
                                    $response = \App\Models\Gn_Test_Response::where('student_id', $studentId)
                                        ->where('test_id', $testId)
                                        ->where('question_id', $question->id)
                                        ->first();
                                    
                                    $isCorrect = $response && $response->answer === $question->mcq_answer;
                                    $isUnattempted = !$response || $response->answer === null || $response->answer === '';

                                    $badgeClass = $isUnattempted ? 'badge-neutral' : ($isCorrect ? 'badge-success' : 'badge-error');
                                    $badgeLabel = $isUnattempted ? 'Not Attempted' : ($isCorrect ? 'Correct' : 'Incorrect');
                                @endphp

                                <details class="collapse collapse-arrow bg-base-100 border border-base-200 shadow-sm" open>
                                    <summary class="collapse-title text-lg font-medium flex items-center gap-3">
                                        <span class="w-8 h-8 rounded-full bg-base-200 flex items-center justify-center text-sm font-bold">{{ $qIndex + 1 }}</span>
                                        <span class="flex-1 line-clamp-1">{!! strip_tags($question->question) !!}</span>
                                        <x-badge value="{{ $badgeLabel }}" class="{{ $badgeClass }}" />
                                    </summary>
                                    <div class="collapse-content px-6 pb-6 border-t border-base-200 pt-4">
                                        <div class="prose max-w-none text-base-content mb-6">
                                            {!! $question->question !!}
                                        </div>

                                        <div class="space-y-3 mb-6">
                                            @for ($k = 1; $k <= $question->mcq_options; $k++)
                                                @php 
                                                    $optKey = 'ans_' . $k;
                                                    $itemClass = 'bg-base-50 border-base-200';
                                                    
                                                    if ($question->mcq_answer === $optKey) {
                                                        $itemClass = 'bg-success/10 border-success text-success-content';
                                                    } elseif ($response && $response->answer === $optKey && !$isCorrect) {
                                                        $itemClass = 'bg-error/10 border-error text-error-content';
                                                    }
                                                @endphp
                                                <div class="p-3 rounded-lg border flex gap-3 {{ $itemClass }}">
                                                    <span class="font-bold opacity-70">({{ chr(64 + $k) }})</span>
                                                    <div class="prose max-w-none m-0 {!! $itemClass !!}">{!! $question->$optKey !!}</div>
                                                </div>
                                            @endfor
                                        </div>

                                        @if ($test->show_solution == 1 && ($question->solution || $question->explanation))
                                            <div class="bg-primary/5 border border-primary/20 rounded-lg p-5 mt-4">
                                                @if ($question->solution)
                                                    <div class="mb-3">
                                                        <h4 class="font-bold text-primary flex items-center gap-2 mb-2"><x-icon name="o-light-bulb" class="w-5 h-5"/> Solution</h4>
                                                        <div class="prose max-w-none text-sm">{!! $question->solution !!}</div>
                                                    </div>
                                                @endif
                                                @if ($question->explanation)
                                                    <div>
                                                        <h4 class="font-bold text-primary flex items-center gap-2 mb-2 mt-4 pt-4 border-t border-primary/10"><x-icon name="o-book-open" class="w-5 h-5"/> Explanation</h4>
                                                        <div class="prose max-w-none text-sm">{!! $question->explanation !!}</div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </details>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @else
                <div class="flex flex-col items-center justify-center p-12 bg-base-100 border border-base-200 rounded-xl text-center shadow-sm">
                    <x-icon name="o-lock-closed" class="w-20 h-20 text-warning mb-4" />
                    <h3 class="text-2xl font-bold mb-2">Detailed Review Locked</h3>
                    <p class="text-base-content/70">Responses & solutions for this exam are currently hidden by the administrator.</p>
                </div>
            @endif
        </div>
    </div>
</div>
