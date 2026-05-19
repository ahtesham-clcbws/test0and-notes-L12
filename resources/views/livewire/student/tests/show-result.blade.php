<div class="min-h-screen bg-[#f8fafc] flex flex-col font-sans" wire:ignore.self>
    {{-- Top Header (Brand Consistent) --}}
    <div class="bg-white border-b border-gray-200 px-8 py-4 flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center gap-4">
            <div class="bg-[#16a34a] text-white p-2 rounded-lg">
                <x-icon name="o-academic-cap" class="w-8 h-8" />
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-800 leading-tight">{{ $test->title }}</h1>
                @php
                    $attempt = \App\Models\TestAttempt::find($attemptId);
                    $submittedTime = $attempt && $attempt->submitted_at ? $attempt->submitted_at : ($attempt ? $attempt->updated_at : now());
                @endphp
                <div class="flex items-center gap-2 text-xs font-bold text-gray-500 uppercase tracking-widest mt-1">
                    <x-icon name="o-clock" class="w-3 h-3" />
                    Completed: {{ strtoupper($submittedTime->format('d M Y, h:i A')) }}
                </div>
            </div>
        </div>
        <div class="flex items-center gap-6">
            <div class="text-right font-bold text-gray-700 text-lg sm:text-xl tracking-tight">
                Duration: {{ $test->time_to_complete ?? 60 }} Minutes
            </div>
        </div>
    </div>

    <div class="flex-1 p-8 max-w-7xl mx-auto w-full">
        {{-- Stats Grid --}}
        {{-- Result Mode Stats Grid: Premium Color-Coded 5 Boxes matching template exactly --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5 mb-10">
            {{-- Box 1: Total Questions --}}
            <div class="bg-[#f5d0b9] border border-[#c7936f] p-5 rounded-2xl flex items-center gap-4 shadow-sm min-h-22.5">
                <div class="w-10 h-10 rounded-full border border-[#bc8c69] bg-[#e5b493] shrink-0"></div>
                <div class="flex-1 font-semibold text-xs text-[#3d2e24] leading-normal">
                    <div class="flex justify-between items-center">
                        <span>Total Questions</span>
                        <span class="text-xl font-black text-[#1a1510]">{{ $total_question }}</span>
                    </div>
                    <div class="flex justify-between items-center mt-1">
                        <span>Total Marks</span>
                        <span class="text-xl font-black text-[#1a1510]">{{ $out_of_marks }}</span>
                    </div>
                </div>
            </div>

            {{-- Box 2: Correct Answers --}}
            <div class="bg-[#f3a88a] border border-[#c57e62] p-5 rounded-2xl flex items-center gap-4 shadow-sm min-h-22.5">
                <div class="w-10 h-10 rounded-full border border-[#aa5c40] bg-[#e09477] shrink-0"></div>
                <div class="flex-1 font-semibold text-xs text-[#4c1c0a] leading-normal">
                    <div class="flex justify-between items-center">
                        <span>Correct Answers</span>
                        <span class="text-xl font-black text-[#2e1005]">{{ $correct_answer }}</span>
                    </div>
                    <div class="flex justify-between items-center mt-1">
                        <span>Obtain Marks</span>
                        <span class="text-xl font-black text-[#2e1005]">{{ $total_marks }}</span>
                    </div>
                </div>
            </div>

            {{-- Box 3: Wrong Answers --}}
            <div class="bg-[#fecaca] border border-[#f87171] p-5 rounded-2xl flex items-center gap-4 shadow-sm min-h-22.5">
                <div class="w-10 h-10 rounded-full border border-[#ef4444] bg-[#fee2e2] shrink-0"></div>
                <div class="flex-1 font-semibold text-xs text-[#7f1d1d] leading-normal">
                    <div class="flex justify-between items-center">
                        <span>Wrong Answers</span>
                        <span class="text-xl font-black text-[#991b1b]">{{ $incorrect_answer }}</span>
                    </div>
                    <div class="flex justify-between items-center mt-1">
                        <span>Negative Marks</span>
                        <span class="text-xl font-black text-[#991b1b]">{{ $negative_marks }}</span>
                    </div>
                </div>
            </div>

            {{-- Box 4: Left Questions --}}
            <div class="bg-[#f3f4f6] border border-[#d1d5db] p-5 rounded-2xl flex items-center gap-4 shadow-sm min-h-22.5">
                <div class="w-10 h-10 rounded-full border border-[#9ca3af] bg-[#e5e7eb] shrink-0"></div>
                <div class="flex-1 font-semibold text-xs text-[#374151] leading-normal">
                    <div class="flex justify-between items-center">
                        <span>Left Questions</span>
                        <span class="text-xl font-black text-[#111827]">{{ $not_attempted }}</span>
                    </div>
                    <div class="flex justify-between items-center mt-1">
                        <span>Left Marks</span>
                        <span class="text-xl font-black text-[#111827]">0</span>
                    </div>
                </div>
            </div>

            {{-- Box 5: Final Score --}}
            <div class="bg-[#f0fdf4] border border-[#86efac] p-5 rounded-2xl flex items-center gap-4 shadow-sm min-h-22.5">
                <div class="w-10 h-10 rounded-full border border-[#22c55e] bg-[#dcfce7] shrink-0"></div>
                <div class="flex-1 font-semibold text-xs text-[#14532d] leading-normal">
                    <div class="flex justify-between items-center">
                        <span>Final Score</span>
                        <span class="text-2xl font-black text-[#16a34a]">{{ $final_marks }}</span>
                    </div>
                    <div class="flex justify-between items-center mt-1">
                        <span>Accuracy</span>
                        @php 
                            $attempted = $correct_answer + $incorrect_answer;
                            $accuracy = $attempted > 0 ? ($correct_answer / $attempted) * 100 : 0;
                        @endphp
                        <span class="text-md font-bold text-[#15803d]">{{ round($accuracy, 1) }}%</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Analysis Area (2 Column Layout) --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            {{-- Left Column: Question Grid --}}
            <div class="lg:col-span-2 bg-white border border-gray-100 p-8 rounded-3xl shadow-sm space-y-6">
                <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">Question Panel</h3>
                    <div class="flex gap-2">
                        <span class="px-3 py-1 bg-green-50 text-green-700 rounded-lg text-xs font-bold border border-green-100 flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span> Correct
                        </span>
                        <span class="px-3 py-1 bg-red-50 text-red-700 rounded-lg text-xs font-bold border border-red-100 flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span> Wrong
                        </span>
                        <span class="px-3 py-1 bg-gray-50 text-gray-600 rounded-lg text-xs font-bold border border-gray-100 flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-gray-200 border border-gray-300"></span> Unattempted
                        </span>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    @php 
                        $responses = $attempt ? \App\Models\TestAttemptAnswer::where('test_attempt_id', $attempt->id)
                            ->get()
                            ->keyBy('question_id') : collect();
                        $allQuestions = $test->getQuestions()->distinct()->get();
                    @endphp

                    @foreach ($allQuestions as $index => $question)
                        @php
                            $resp = $responses->get($question->id);
                            $isAttempted = $resp && $resp->answer !== null && $resp->answer !== '';
                            
                            if ($isAttempted) {
                                $isCorrect = $question->mcq_answer === $resp->answer;
                                if ($isCorrect) {
                                    $circleBg = 'bg-[#16a34a] text-white hover:bg-[#15803d] border-[#16a34a]';
                                } else {
                                    $circleBg = 'bg-red-500 text-white hover:bg-red-600 border-red-500';
                                }
                            } else {
                                $circleBg = 'bg-gray-200 text-gray-700 hover:bg-gray-300 border-gray-200';
                            }
                        @endphp
                        <button 
                            wire:click="viewSolution({{ $question->id }})"
                            class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-xs shadow-sm transition-all border {{ $circleBg }} cursor-pointer hover:scale-105"
                        >
                            {{ $index + 1 }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Right Column: Side Card Guide & Instructions --}}
            <div class="bg-white border border-gray-100 p-8 rounded-3xl shadow-sm space-y-6">
                <h3 class="text-lg font-bold text-gray-800 pb-4 border-b border-gray-100 flex items-center gap-2">
                    <x-icon name="o-clipboard-document-check" class="w-6 h-6 text-[#2a2973]" />
                    Test Summary & Guide
                </h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center text-sm font-semibold text-gray-600">
                        <span>Total Questions</span>
                        <span class="text-gray-800 font-extrabold">{{ $total_question }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm font-semibold text-gray-600">
                        <span>Attempted Questions</span>
                        <span class="text-green-600 font-extrabold">{{ $attemptedCount }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm font-semibold text-gray-600">
                        <span>Unattempted Questions</span>
                        <span class="text-gray-500 font-extrabold">{{ $unattemptedCount }}</span>
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5 mt-6">
                    <h4 class="text-blue-800 font-bold text-sm flex items-center gap-2 mb-2">
                        <x-icon name="o-information-circle" class="w-5 h-5 text-blue-600" />
                        Static Analysis View
                    </h4>
                    <p class="text-xs text-blue-700 leading-relaxed font-medium">
                        Click on any numbered question bubble to view the correct answer, your response, and detailed step-by-step solutions/explanations.
                    </p>
                </div>

                <div class="pt-6">
                    <a 
                        href="{{ route('student.dashboard') }}" 
                        class="w-full bg-gray-900 hover:bg-black text-white py-3.5 rounded-xl font-bold transition-all shadow-md text-center block"
                    >
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- SOLUTION POPUP --}}
    @if($showSolutionModal && $selectedQuestionId)
        @php 
            $q = \App\Models\QuestionBankModel::find($selectedQuestionId); 
            $studentResp = \App\Models\TestAttemptAnswer::where('test_attempt_id', $attemptId)->where('question_id', $q->id)->first();
        @endphp
        <div class="fixed inset-0 bg-black/60 z-100 flex items-center justify-center p-6 backdrop-blur-sm">
            <div class="bg-white rounded-3xl w-full max-w-4xl overflow-hidden shadow-2xl flex flex-col max-h-[90vh]">
                <div class="bg-white border-b border-gray-100 p-6 flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <span class="bg-[#16a34a] text-white px-3 py-1 rounded-lg font-bold text-sm">
                            Solution Review
                        </span>
                        <span class="text-gray-400 font-bold text-sm">#{{ $selectedQuestionId }}</span>
                    </div>
                    <button wire:click="$set('showSolutionModal', false)" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <x-icon name="o-x-mark" class="w-8 h-8" />
                    </button>
                </div>
                
                <div class="flex-1 overflow-y-auto p-8 space-y-8">
                    {{-- Question Text --}}
                    <div class="prose max-w-none">
                        <h2 class="text-xl font-bold text-gray-800 leading-relaxed">
                            {!! $q->question !!}
                        </h2>
                    </div>

                    {{-- Options --}}
                    <div class="grid grid-cols-1 gap-4">
                        @for ($k = 1; $k <= $q->mcq_options; $k++)
                            @php 
                                $optKey = 'ans_' . $k;
                                $isStudentOpt = $studentResp && $studentResp->answer === $optKey;
                                $isCorrectOpt = $q->mcq_answer === $optKey;
                                
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
                                <div class="w-6 h-6 border shrink-0 mt-0.5 flex items-center justify-center {{ $indicatorClass }}">
                                    @if($isCorrectOpt)
                                        <x-icon name="s-check" class="w-4 h-4" />
                                    @elseif($isStudentOpt)
                                        <x-icon name="s-x-mark" class="w-4 h-4" />
                                    @else
                                        <span class="text-[10px] font-bold">{{ chr(64 + $k) }}</span>
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
                                <x-icon name="o-information-circle" class="w-5 h-5 animate-pulse" />
                                Explanation & Solution
                            </h4>
                            <div class="text-blue-900 text-[14px] leading-relaxed prose-sm prose-blue max-w-none">
                                {!! $q->explanation ?? $q->solution !!}
                            </div>
                        </div>
                    @endif
                </div>

                <div class="p-6 bg-gray-50 flex justify-end items-center border-t border-gray-100">
                    <button wire:click="$set('showSolutionModal', false)" class="bg-gray-900 text-white px-8 py-3 rounded-xl font-bold hover:bg-black transition-colors cursor-pointer">
                        Close Analysis
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
