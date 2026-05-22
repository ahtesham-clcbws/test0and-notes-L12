<div class="min-h-screen bg-[#f8fafc] flex flex-col font-sans" wire:ignore.self>
    {{-- Floating Timer Widget --}}
    <div class="fixed top-6 right-6 z-50 flex items-center gap-2 text-[#dc2626] font-bold text-lg bg-red-50 px-4 py-2 rounded-xl border border-red-100 shadow-md">
        <x-icon name="o-clock" class="w-5 h-5 animate-pulse" />
        <span class="text-xs font-semibold uppercase tracking-wider">Time Left:</span>
        <span class="font-extrabold" x-data="{ 
            endTimestamp: {{ $endTimestamp }},
            timer: '00:00:00',
            submitted: false,
            init() {
                this.update();
                setInterval(() => this.update(), 1000);
            },
            update() {
                let now = Date.now();
                let diff = Math.max(0, Math.floor((this.endTimestamp - now) / 1000));
                
                if (diff <= 0) {
                    this.timer = '00:00:00';
                    if (!this.submitted) {
                        this.submitted = true;
                        $wire.submitTest();
                    }
                    return;
                }

                let h = Math.floor(diff / 3600);
                let m = Math.floor((diff % 3600) / 60);
                let s = diff % 60;
                this.timer = [h, m, s].map(v => v.toString().padStart(2, '0')).join(':');
            }
        }" x-text="timer">00:00:00</span>
    </div>

    {{-- Dedicated Centered Review Mode Layout --}}
    <div class="flex-1 bg-white p-6 max-w-5xl mx-auto w-full flex flex-col justify-start">
        {{-- Centered Header --}}
        <div class="text-center py-6 mt-4">
            <h1 class="text-4xl font-extrabold text-[#2a2973] tracking-tight">Test Review & Submission</h1>
            <p class="text-md font-bold text-[#c93f53] mt-2 uppercase tracking-wider">
                {{ $test->title }}
            </p>
        </div>

        {{-- Centered Stats Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center px-4 max-w-4xl mx-auto w-full mt-4">
            <!-- Completion Card -->
            <div class="bg-[#d8f0fa] border border-[#b2e0f4] rounded-2xl p-6 flex items-center justify-between shadow-sm min-h-35 w-full">
                <span class="text-2xl font-extrabold text-[#2a2973]">Completion</span>
                @php 
                    $percent = $total_question > 0 ? ($attemptedCount / $total_question) * 100 : 0; 
                @endphp
                <div class="relative inline-flex items-center justify-center">
                    <svg class="w-24 h-24 transform -rotate-90">
                        <circle cx="48" cy="48" r="42" stroke="currentColor" stroke-width="6" fill="transparent" class="text-[#b2e0f4]" />
                        <circle cx="48" cy="48" r="42" stroke="currentColor" stroke-width="6" fill="transparent" stroke-dasharray="{{ 263.89 }}" stroke-dashoffset="{{ 263.89 - (263.89 * $percent / 100) }}" class="text-[#0ea5e9] transition-all duration-1000" />
                    </svg>
                    <span class="absolute text-xl font-black text-[#2a2973]">{{ round($percent) }}%</span>
                </div>
            </div>
            
            <!-- 2x2 Grid of Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:col-span-2 w-full">
                <!-- Attempted -->
                <div class="bg-[#f0fdf4] border-2 border-[#86efac] px-5 py-4 rounded-xl flex justify-between items-center shadow-sm">
                    <span class="text-[#14532d] text-lg font-extrabold">Attempted</span>
                    <span class="text-3xl font-black text-[#16a34a]">{{ $attemptedCount }}</span>
                </div>
                
                <!-- Not Attempted -->
                <div class="bg-[#f9fafb] border-2 border-[#d1d5db] px-5 py-4 rounded-xl flex justify-between items-center shadow-sm">
                    <span class="text-[#374151] text-lg font-extrabold">Not Attempted</span>
                    <span class="text-3xl font-black text-[#6b7280]">{{ $unattemptedCount }}</span>
                </div>
                
                <!-- For Review -->
                <div class="bg-[#fefdf0] border-[3px] border-yellow-400 px-5 py-4 rounded-xl flex justify-between items-center shadow-sm">
                    <span class="text-[#713f12] text-lg font-extrabold">For Review</span>
                    <span class="text-3xl font-black text-[#ca8a04]">{{ $reviewCount }}</span>
                </div>
                
                <!-- Total Visit -->
                <div class="bg-[#f5f3ff] border-2 border-[#ddd6fe] px-5 py-4 rounded-xl flex justify-between items-center shadow-sm">
                    <span class="text-[#4c1d95] text-lg font-extrabold">Total Visit</span>
                    <span class="text-3xl font-black text-[#7c3aed]">{{ $visitedCount }}</span>
                </div>
            </div>
        </div>

        {{-- Bubble Grid --}}
        <div class="max-w-4xl mx-auto w-full px-6 py-6 bg-white border border-gray-100 rounded-3xl shadow-sm mt-8">
            <div class="flex flex-wrap justify-center gap-3">
                @php 
                    $attempt = \App\Models\TestAttempt::find($attemptId);
                    $responses = $attempt ? \App\Models\TestAttemptAnswer::where('test_attempt_id', $attempt->id)
                        ->get()
                        ->keyBy('question_id') : collect();
                    $allQuestions = $test->getQuestions()->distinct()->get();
                @endphp

                @foreach ($allQuestions as $index => $question)
                    @php
                        $resp = $responses->get($question->id);
                        $isAnswered = $resp && $resp->answer !== null && $resp->answer !== '';
                        $isVisited = $resp && $resp->is_visited;
                        $isMarked = $resp && $resp->is_marked_for_review;

                        if ($isAnswered) {
                            $circleBg = 'bg-[#16a34a] text-white hover:bg-[#15803d] cursor-pointer ' . ($isMarked ? 'border-[3px] border-yellow-400 shadow-sm hover:scale-110' : 'border-[#16a34a]');
                        } elseif ($isVisited) {
                            $circleBg = 'bg-gray-200 text-gray-700 hover:bg-gray-300 cursor-pointer border-gray-300 ' . ($isMarked ? 'border-[3px] border-yellow-400 shadow-sm hover:scale-110' : 'border');
                        } else {
                            $circleBg = 'bg-white text-gray-500 border border-gray-300 hover:bg-gray-50 cursor-pointer ' . ($isMarked ? 'border-[3px] border-yellow-400 shadow-sm hover:scale-110' : '');
                        }
                    @endphp
                    <button 
                        wire:click="viewSolution({{ $question->id }})"
                        class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-xs shadow-sm transition-all {{ $circleBg }}"
                        title="Question {{ $index + 1 }}"
                    >
                        {{ $index + 1 }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Guide Info Alert --}}
        <div class="max-w-4xl mx-auto w-full mt-8 px-4">
            <div class="bg-blue-50 border-l-4 border-blue-500 rounded-2xl p-5 flex gap-4 items-start shadow-sm">
                <div class="bg-blue-500 text-white p-2 rounded-xl shrink-0">
                    <x-icon name="o-information-circle" class="w-6 h-6" />
                </div>
                <div class="flex-1">
                    <h4 class="text-blue-900 font-extrabold text-lg">💡 Student Guide: Question Review & Re-attempt</h4>
                    <p class="text-blue-800 text-sm font-medium mt-1 leading-relaxed">
                        Click on any question bubble above to review your recorded choice or answer/modify it directly here in the popup.
                    </p>
                </div>
            </div>
        </div>

        {{-- Footer warning text --}}
        <div class="text-center mt-8 px-4 max-w-2xl mx-auto">
            <p class="text-xs font-semibold text-[#c75a6c] leading-relaxed">
                Please review your attempted questions carefully. Once you click "Submit Test Now" you will no longer be able to change your answers, your result will be calculated based on the responses recorded above.
            </p>
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center justify-center mt-6 pb-12">
            <button 
                wire:click="submitTest" 
                class="bg-[#2a2973] hover:bg-[#1f1e58] text-white text-lg font-extrabold px-16 py-4 rounded-2xl shadow-lg transition-all hover:scale-105 cursor-pointer"
            >
                Submit Test Now
            </button>
        </div>
    </div>

    {{-- RE-ATTEMPT MODAL --}}
    @if($showSolutionModal && $selectedQuestionId)
        @php 
            $q = \App\Models\QuestionBankModel::find($selectedQuestionId); 
            $studentResp = \App\Models\TestAttemptAnswer::where('test_attempt_id', $attemptId)->where('question_id', $q->id)->first();
            $isMarkedForReview = $studentResp && $studentResp->is_marked_for_review;
        @endphp
        <div 
            wire:click.self="$set('showSolutionModal', false)"
            class="fixed inset-0 bg-black/60 z-100 flex items-center justify-center p-6 backdrop-blur-sm"
        >
            <div class="bg-white rounded-3xl w-full max-w-4xl overflow-hidden shadow-2xl flex flex-col max-h-[90vh]">
                <div class="bg-white border-b border-gray-100 p-6 flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <span class="bg-[#16a34a] text-white px-3 py-1 rounded-lg font-bold text-sm">
                            Re-attempt & Answer Question
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
                                $isSelected = $selectedAnswer === $optKey;
                                
                                if ($isSelected) {
                                    $boxClass = 'bg-blue-50 border-blue-300 text-blue-800 ring-2 ring-blue-100';
                                    $indicatorClass = 'bg-blue-600 border-blue-600 text-white';
                                } else {
                                    $boxClass = 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50 hover:border-gray-300 cursor-pointer';
                                    $indicatorClass = 'bg-gray-100 border-gray-200 text-gray-400';
                                }
                            @endphp
                            
                            <div 
                                wire:click="selectAnswerOption('{{ $optKey }}')"
                                class="flex items-start gap-4 p-4 rounded-xl border transition-all {{ $boxClass }}"
                            >
                                <div class="w-6 h-6 border shrink-0 mt-0.5 flex items-center justify-center {{ $indicatorClass }}">
                                    @if($isSelected)
                                        <x-icon name="s-check" class="w-4 h-4" />
                                    @else
                                        <span class="text-[10px] font-bold">{{ chr(64 + $k) }}</span>
                                    @endif
                                </div>
                                <div class="flex-1 text-[15px] leading-relaxed select-none">
                                    {!! $q->$optKey !!}
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>

                <div class="p-6 bg-gray-50 flex justify-between items-center border-t border-gray-100">
                    <button 
                        wire:click="clearReviewAnswer"
                        class="bg-gray-100 text-gray-700 px-6 py-3 rounded-xl font-bold hover:bg-gray-200 transition-colors cursor-pointer flex items-center gap-2 border border-gray-200"
                    >
                        Clear Response & Skip
                        <x-icon name="o-trash" class="w-5 h-5" />
                    </button>
                    <button 
                        wire:click="saveReviewAnswer"
                        class="bg-[#16a34a] text-white px-8 py-3 rounded-xl font-bold hover:bg-[#15803d] transition-colors cursor-pointer flex items-center gap-2"
                    >
                        Save & Update Answer
                        <x-icon name="o-check" class="w-5 h-5" />
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
