<div class="min-h-screen bg-[#f8fafc] flex flex-col font-sans" wire:ignore.self>
    {{-- Top Header (Brand Consistent) --}}
    <div class="bg-white border-b border-gray-200 px-8 py-4 flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center gap-4">
            <div class="bg-[#16a34a] text-white p-2 rounded-lg">
                <x-icon name="o-academic-cap" class="w-8 h-8" />
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-800 leading-tight">{{ $test->title }}</h1>
                <div class="flex items-center gap-2 text-xs font-bold text-gray-500 uppercase tracking-widest">
                    <x-icon name="o-clock" class="w-3 h-3" />
                    Completed: {{ $test->updated_at->format('d M Y, h:i A') }}
                </div>
            </div>
        </div>
        <div class="text-right">
            <div class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Final Score</div>
            <div class="text-3xl font-black text-[#16a34a] tracking-tighter">
                {{ number_format($final_marks, 1) }} <span class="text-lg text-gray-400 font-bold">/ {{ $out_of_marks }}</span>
            </div>
        </div>
    </div>

    <div class="flex-1 p-8 max-w-7xl mx-auto w-full">
        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5">
                <div class="w-14 h-14 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                    <x-icon name="o-clipboard-document-list" class="w-8 h-8" />
                </div>
                <div>
                    <div class="text-2xl font-black text-gray-800">{{ $total_question }}</div>
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Questions</div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5">
                <div class="w-14 h-14 rounded-xl bg-green-50 flex items-center justify-center text-[#16a34a]">
                    <x-icon name="o-check-circle" class="w-8 h-8" />
                </div>
                <div>
                    <div class="text-2xl font-black text-[#16a34a]">{{ $correct_answer }}</div>
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-widest">Correct Answers</div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5">
                <div class="w-14 h-14 rounded-xl bg-red-50 flex items-center justify-center text-red-600">
                    <x-icon name="o-x-circle" class="w-8 h-8" />
                </div>
                <div>
                    <div class="text-2xl font-black text-red-600">{{ $incorrect_answer }}</div>
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-widest">Wrong Answers</div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5">
                <div class="w-14 h-14 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400">
                    <x-icon name="o-minus-circle" class="w-8 h-8" />
                </div>
                <div>
                    <div class="text-2xl font-black text-gray-600">{{ $not_attempted }}</div>
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-widest">Not Attempted</div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left Column: Question Palette --}}
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 px-8 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="font-bold text-gray-800">Answer Analysis Palette</h3>
                        <div class="flex gap-4 text-[10px] font-bold uppercase tracking-widest">
                            <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-[#16a34a]"></span> Correct</span>
                            <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-red-500"></span> Wrong</span>
                            <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-gray-200"></span> Skipped</span>
                        </div>
                    </div>
                    <div class="p-8">
                        @if($test->show_answer == 1)
                            <div class="grid grid-cols-5 sm:grid-cols-8 md:grid-cols-10 gap-3">
                                @php 
                                    $attempt = \App\Models\TestAttempt::find($this->attemptId);
                                    $responses = $attempt ? \App\Models\TestAttemptAnswer::where('test_attempt_id', $attempt->id)
                                        ->get()
                                        ->keyBy('question_id') : collect();
                                    $allQuestions = $test->getQuestions()->distinct()->get();
                                @endphp

                                @foreach ($allQuestions as $index => $question)
                                    @php
                                        $resp = $responses->get($question->id);
                                        $isCorrect = $resp && $resp->answer === $question->mcq_answer;
                                        $isUnattempted = !$resp || $resp->answer === null || $resp->answer === '';
                                        
                                        $btnClass = 'bg-gray-50 border-gray-200 text-gray-400';
                                        if (!$isUnattempted) {
                                            $btnClass = $isCorrect ? 'bg-[#16a34a] text-white border-[#16a34a]' : 'bg-red-500 text-white border-red-500';
                                        }
                                    @endphp
                                    <button 
                                        wire:click="viewSolution({{ $question->id }})"
                                        class="h-12 w-full rounded-xl flex items-center justify-center font-bold text-sm border-2 transition-all hover:scale-110 shadow-sm cursor-pointer {{ $btnClass }}"
                                    >
                                        {{ $index + 1 }}
                                    </button>
                                @endforeach
                            </div>
                        @else
                            <div class="py-12 text-center">
                                <x-icon name="o-lock-closed" class="w-16 h-16 text-gray-200 mx-auto mb-4" />
                                <p class="text-gray-400 font-bold">Answers are currently locked by the administrator.</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex gap-4">
                    <a href="{{ route('student.dashboard') }}" class="flex-1 bg-white border border-gray-200 text-gray-700 py-4 rounded-2xl font-bold flex items-center justify-center gap-3 hover:bg-gray-50 transition-colors shadow-sm">
                        <x-icon name="o-home" class="w-5 h-5" />
                        Back to Dashboard
                    </a>
                    <a href="{{ route('student.tests.list') }}" class="flex-1 bg-[#16a34a] text-white py-4 rounded-2xl font-bold flex items-center justify-center gap-3 hover:bg-[#15803d] transition-colors shadow-lg shadow-green-200">
                        <x-icon name="o-arrow-path" class="w-5 h-5" />
                        Try Another Test
                    </a>
                </div>
            </div>

            {{-- Right Column: Score Summary Card --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden sticky top-28">
                    <div class="bg-gray-900 p-8 text-white text-center">
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-[0.2em] mb-4">Performance Indicator</div>
                        @php $percent = $out_of_marks > 0 ? ($final_marks / $out_of_marks) * 100 : 0; @endphp
                        <div class="relative inline-flex items-center justify-center">
                            <svg class="w-32 h-32 transform -rotate-90">
                                <circle cx="64" cy="64" r="58" stroke="currentColor" stroke-width="8" fill="transparent" class="text-gray-800" />
                                <circle cx="64" cy="64" r="58" stroke="currentColor" stroke-width="8" fill="transparent" stroke-dasharray="{{ 364.4 }}" stroke-dashoffset="{{ 364.4 - (364.4 * $percent / 100) }}" class="text-[#16a34a] transition-all duration-1000" />
                            </svg>
                            <span class="absolute text-2xl font-black">{{ round($percent) }}%</span>
                        </div>
                        <div class="mt-6 text-xl font-bold">
                            @if($percent >= 90) Outstanding!
                            @elseif($percent >= 75) Excellent Work
                            @elseif($percent >= 60) Good Progress
                            @elseif($percent >= 40) Can Do Better
                            @else Needs Improvement
                            @endif
                        </div>
                    </div>
                    <div class="p-8 space-y-6">
                        <div class="flex justify-between items-center pb-4 border-b border-gray-50">
                            <span class="text-gray-500 font-bold">Accuracy</span>
                            <span class="text-gray-900 font-black">{{ $correct_answer + $incorrect_answer > 0 ? round(($correct_answer / ($correct_answer + $incorrect_answer)) * 100) : 0 }}%</span>
                        </div>
                        <div class="flex justify-between items-center pb-4 border-b border-gray-50">
                            <span class="text-gray-500 font-bold">Negative Marking</span>
                            <span class="text-red-500 font-black">-{{ number_format($negative_marks, 1) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 font-bold">Questions Skipped</span>
                            <span class="text-gray-900 font-black">{{ $not_attempted }}</span>
                        </div>
                    </div>
                    <div class="p-4 bg-gray-50 text-center">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Report ID: #ATT-{{ $attemptId }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SOLUTION MODAL (Squared Design Parity) --}}
    @if($showSolutionModal && $selectedQuestionId)
        @php 
            $q = \App\Models\QuestionBankModel::find($selectedQuestionId); 
            $studentResp = \App\Models\TestAttemptAnswer::where('test_attempt_id', $this->attemptId)->where('question_id', $q->id)->first();
        @endphp
        <div class="fixed inset-0 bg-black/60 z-[100] flex items-center justify-center p-6 backdrop-blur-sm">
            <div class="bg-white rounded-3xl w-full max-w-4xl overflow-hidden shadow-2xl flex flex-col max-h-[90vh]">
                <div class="bg-white border-b border-gray-100 p-6 flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <span class="bg-[#16a34a] text-white px-3 py-1 rounded-lg font-bold text-sm">Question Review</span>
                        <span class="text-gray-400 font-bold text-sm">#{{ $selectedQuestionId }}</span>
                    </div>
                    <button wire:click="$set('showSolutionModal', false)" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <x-icon name="o-x-mark" class="w-8 h-8" />
                    </button>
                </div>
                
                <div class="flex-1 overflow-y-auto p-8 space-y-10">
                    {{-- Question Text --}}
                    <div class="prose max-w-none">
                        <h2 class="text-xl font-bold text-gray-800 leading-relaxed">
                            {!! $q->question !!}
                        </h2>
                    </div>

                    {{-- Options (Squared Theme Parity) --}}
                    <div class="grid grid-cols-1 gap-4">
                        @for ($k = 1; $k <= $q->mcq_options; $k++)
                            @php 
                                $optKey = 'ans_' . $k;
                                $isCorrectOpt = $q->mcq_answer === $optKey;
                                $isStudentOpt = $studentResp && $studentResp->answer === $optKey;
                                
                                $boxClass = 'bg-[#f8f9fa] border-gray-200 text-gray-600';
                                $indicatorClass = 'bg-gray-100 border-gray-300';
                                
                                if ($isCorrectOpt) {
                                    $boxClass = 'bg-green-50 border-green-200 text-green-800';
                                    $indicatorClass = 'bg-[#16a34a] border-[#16a34a] text-white';
                                } elseif ($isStudentOpt) {
                                    $boxClass = 'bg-red-50 border-red-200 text-red-800';
                                    $indicatorClass = 'bg-red-500 border-red-500 text-white';
                                }
                            @endphp
                            <div class="flex items-start gap-4 p-4 rounded-xl border transition-all {{ $boxClass }}">
                                {{-- Squared Status Indicator --}}
                                <div class="w-6 h-6 border flex-shrink-0 mt-0.5 flex items-center justify-center {{ $indicatorClass }}">
                                    @if($isCorrectOpt)
                                        <x-icon name="s-check" class="w-4 h-4" />
                                    @elseif($isStudentOpt)
                                        <x-icon name="s-x-mark" class="w-4 h-4" />
                                    @else
                                        <span class="text-[10px] font-bold text-gray-400">{{ chr(64 + $k) }}</span>
                                    @endif
                                </div>
                                <div class="flex-1 text-[15px] leading-relaxed">
                                    {!! $q->$optKey !!}
                                </div>
                            </div>
                        @endfor
                    </div>

                    {{-- Solution/Explanation Box --}}
                    @if($q->explanation || $q->solution)
                        <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6">
                            <h4 class="text-blue-800 font-bold flex items-center gap-2 mb-3 text-sm">
                                <x-icon name="o-information-circle" class="w-5 h-5" />
                                Explanation & Solution
                            </h4>
                            <div class="text-blue-900 text-[14px] leading-relaxed prose-sm prose-blue max-w-none">
                                {!! $q->explanation ?? $q->solution !!}
                            </div>
                        </div>
                    @endif
                </div>

                <div class="p-6 bg-gray-50 text-right border-t border-gray-100">
                    <button wire:click="$set('showSolutionModal', false)" class="bg-gray-900 text-white px-8 py-2 rounded-xl font-bold hover:bg-black transition-colors">
                        Close Analysis
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
