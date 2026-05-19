<div class="min-h-screen bg-white font-sans text-gray-800 flex flex-col" wire:ignore.self>

    {{-- 1. TOP HEADER --}}
    <div class="px-8 py-5 flex justify-between items-center border-b border-gray-200 sticky top-0 z-50 bg-white">
        <div class="flex items-center">
            <h1 class="text-2xl font-bold text-[#16a34a]">{{ $test->title }}</h1>
        </div>
        <div class="flex items-center gap-12">
            <div class="flex items-center gap-2 text-[#dc2626] font-bold text-xl">
                <span>Time Left :</span>
                <span class="font-bold" x-data="{ 
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
            <div class="font-bold text-xl text-black">
                Qs: {{ $totalQuestions }}
            </div>
        </div>
    </div>

    <div class="flex-1 flex px-8 py-6 gap-8 w-full max-w-none mx-auto">
            
            {{-- Left Column: Question Area --}}
            <div class="flex-1 flex flex-col">
                @if ($currentQuestion)
                    <h2 class="text-black font-bold text-lg mb-4">Question No {{ $currentQuestionIndex + 1 }}</h2>
                    
                    {{-- Section Tabs --}}
                    <div class="flex items-center gap-2 mb-6 border-b border-gray-200 pb-2">
                        @foreach ($sections as $i => $section)
                            <div 
                                wire:key="sec-{{ $i }}"
                                class="px-4 py-2 font-bold text-sm transition-colors {{ $currentSectionIndex == $i ? 'bg-[#16a34a] text-white' : 'bg-[#94b4a4] text-gray-800' }}" 
                            >
                                {{ $section['section_subject_part']['name'] ?? $section['section_subject']['name'] }}
                            </div>
                        @endforeach
                    </div>

                    {{-- Question Content --}}
                    <div class="flex-1 overflow-y-auto pr-4 mb-6">
                        <div class="text-base text-gray-800 mb-6 leading-relaxed">
                            Qs {{ $currentQuestionIndex + 1 }}- {!! $currentQuestion->question !!}
                        </div>

                        <div class="flex flex-col gap-4" wire:key="options-{{ $currentQuestion->id }}-{{ count($answers) }}">
                            @for ($k = 1; $k <= $currentQuestion->mcq_options; $k++)
                                @php 
                                    $optKey = 'ans_' . $k; 
                                    $isSelected = ($answers[$currentQuestion->id] ?? '') == $optKey;
                                @endphp
                                <label 
                                    class="flex items-start gap-4 p-3 rounded-md transition-all cursor-pointer group hover:bg-gray-50 border {{ $isSelected ? 'border-[#16a34a]/30 bg-[#16a34a]/5' : 'border-transparent' }}"
                                    wire:click="saveSelection({{ $currentQuestion->id }}, '{{ $optKey }}')"
                                >
                                    <div class="relative shrink-0 mt-0.5">
                                        <input 
                                            type="radio" 
                                            name="q_{{ $currentQuestion->id }}" 
                                            wire:key="opt-real-{{ $currentQuestion->id }}-{{ $k }}-{{ isset($answers[$currentQuestion->id]) ? 'set' : 'empty' }}"
                                            value="{{ $optKey }}" 
                                            {{ $isSelected ? 'checked' : '' }} 
                                            class="sr-only" 
                                        />
                                        {{-- Custom Squared Radio --}}
                                        <div class="w-5 h-5 border transition-all flex items-center justify-center {{ $isSelected ? 'bg-[#16a34a] border-[#16a34a]' : 'bg-[#f8f9fa] border-gray-300 group-hover:border-[#16a34a]' }}">
                                            @if($isSelected)
                                                <x-icon name="o-check" class="w-3.5 h-3.5 text-white" />
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-[15px] text-gray-700 leading-relaxed pt-0">
                                        <span class="font-bold text-gray-400 mr-2">{{ chr(64 + $k) }}.</span>
                                        {!! $currentQuestion->$optKey !!}
                                    </div>
                                </label>
                            @endfor
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="pt-4 flex items-center justify-between border-t border-gray-200 mt-6">
                        <div class="flex gap-2">
                            <button 
                                wire:click="toggleMarkForReview({{ $currentQuestion->id }})"
                                class="bg-[#16a34a] text-white px-5 py-2 font-bold text-sm flex items-center gap-2 hover:bg-[#15803d] transition-colors cursor-pointer"
                            >
                                <x-icon name="s-star" class="w-5 h-5 text-yellow-300" />
                                Mark for Review
                            </button>
                            
                            <button 
                                wire:click="clearResponse({{ $currentQuestion->id }})" 
                                class="bg-[#94b4a4] text-white px-5 py-2 font-bold text-sm flex items-center gap-2 hover:bg-[#7fa391] transition-colors cursor-pointer"
                            >
                                <x-icon name="o-trash" class="w-5 h-5 text-red-500" />
                                Clear Response
                            </button>
                        </div>

                        @if (empty($answers[$currentQuestion->id]))
                            <button 
                                wire:click="$set('showSkipConfirmationModal', true)"
                                class="bg-gray-500 text-white px-6 py-2 font-bold text-sm flex items-center gap-2 hover:bg-gray-600 transition-colors cursor-pointer"
                            >
                                <x-icon name="o-chevron-double-right" class="w-5 h-5" />
                                Skip & Next
                            </button>
                        @else
                            <button 
                                wire:click="saveAndNext"
                                class="bg-[#16a34a] text-white px-6 py-2 font-bold text-sm flex items-center gap-2 hover:bg-[#15803d] transition-colors cursor-pointer"
                            >
                                <x-icon name="o-arrow-right-circle" class="w-5 h-5" />
                                Save & Next
                            </button>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Right Column: Sidebar (Exact Mockup Match) --}}
            <div class="w-120 border border-[#16a34a] flex flex-col h-fit self-start shrink-0 bg-white">
                
                {{-- Profile Section --}}
                <div class="flex bg-[#a7d6b4]">
                    <div class="w-20 h-20 flex items-center justify-center border-r border-white p-2">
                        <img src="{{ '/storage/' . auth()->user()->user_details->photo_url }}" class="w-14 h-14 rounded-full object-cover">
                    </div>
                    <div class="flex-1 flex items-center justify-center text-center px-3">
                        <div class="font-bold text-gray-900 text-lg leading-tight">{{ auth()->user()->name }}</div>
                    </div>
                </div>

                {{-- Section Title Banner --}}
                <div class="bg-[#16a34a] text-white text-center py-2">
                    <div class="bg-[#16a34a] p-3 text-white font-bold text-sm text-center">
                        {{ $sections[$currentSectionIndex]['section_subject_part']['name'] ?? $sections[$currentSectionIndex]['section_subject']['name'] }}
                    </div>
                </div>

                {{-- Palette Grid --}}
                <div class="p-4 bg-white">
                    <div class="flex flex-wrap gap-1.25 mb-8 justify-start">
                        @foreach($questionsList[$currentSectionIndex] as $index => $qId)
                            @php
                                $isAnswered = isset($answers[$qId]);
                                $isMarked = in_array($qId, $markedQuestions);
                                $isVisited = in_array($qId, $this->visitedQuestions);
                                $isCurrent = ($currentQuestionIndex == $index);
                                $isLocked = !$isVisited && !$isAnswered && !$isMarked && !$isCurrent;

                                if ($isAnswered) {
                                    $bgClass = 'bg-[#16a34a] text-white ' . ($isMarked ? 'border-[3px] border-yellow-400' : 'border-[#16a34a]');
                                } elseif ($isVisited) {
                                    $bgClass = 'bg-gray-200 text-black ' . ($isMarked ? 'border-[3px] border-yellow-400' : 'border-gray-300');
                                } else {
                                    $bgClass = 'bg-white text-black ' . ($isMarked ? 'border-[3px] border-yellow-400' : 'border-gray-300');
                                }

                                if ($isCurrent) {
                                    $bgClass = 'ring-2 ring-blue-500 ring-offset-1 ' . $bgClass;
                                }
                            @endphp
                            
                            @if($isLocked)
                                <div 
                                    wire:key="pal-{{ $qId }}"
                                    class="h-10 w-10 rounded-full border border-gray-100 flex items-center justify-center text-sm font-bold opacity-30 cursor-not-allowed bg-gray-50 text-black"
                                    title="Question Locked"
                                >
                                    {{ $index + 1 }}
                                </div>
                            @else
                                <button 
                                    wire:key="pal-{{ $qId }}"
                                    wire:click="selectQuestion({{ $currentSectionIndex }}, {{ $index }})"
                                    class="h-10 w-10 rounded-full flex items-center justify-center text-sm font-bold transition-all hover:scale-110 {{ $bgClass }}" 
                                >
                                    {{ $index + 1 }}
                                </button>
                            @endif
                        @endforeach
                    </div>

                    {{-- Navigation Links --}}
                    <div class="mt-4 flex flex-col gap-2">
                        <button 
                            wire:click="$set('showQuestionsModal', true)"
                            class="text-[#16a34a] font-bold text-xs hover:underline text-left"
                        >
                            Questions List
                        </button>
                        <button 
                            wire:click="$set('showInstructionsModal', true)"
                            class="text-[#16a34a] font-bold text-xs hover:underline text-left"
                        >
                            Instructions
                        </button>
                    </div>
                </div>

                {{-- Submit Block --}}
                <button 
                    wire:click="goToReview"
                    class="w-full bg-[#16a34a] text-white py-3 font-bold text-lg hover:bg-[#15803d] transition-colors cursor-pointer"
                >
                    Review & Submit
                </button>
            </div>
        </div>

        {{-- MODAL: QUESTIONS LIST --}}
        @if($showQuestionsModal)
            <div class="fixed inset-0 bg-black/60 z-110 flex items-center justify-center p-6">
                <div class="bg-white rounded-lg w-full max-w-5xl overflow-hidden shadow-2xl flex flex-col max-h-[90vh]">
                    <div class="bg-[#16a34a] p-4 text-white flex justify-between items-center">
                        <h3 class="text-xl font-bold">All Questions List</h3>
                        <button wire:click="$set('showQuestionsModal', false)" class="text-white hover:text-gray-200">
                            <x-icon name="o-x-mark" class="w-6 h-6" />
                        </button>
                    </div>
                    <div class="p-6 overflow-y-auto">
                        @foreach($sections as $sIdx => $section)
                            <div class="mb-8">
                                <h4 class="font-bold text-gray-800 border-b border-gray-100 pb-2 mb-4 flex items-center gap-2">
                                    <span class="bg-[#16a34a] text-white w-6 h-6 rounded-full flex items-center justify-center text-xs">{{ $sIdx + 1 }}</span>
                                    {{ $section['section_subject_part']['name'] ?? $section['section_subject']['name'] }}
                                </h4>
                                <div class="grid grid-cols-5 sm:grid-cols-8 md:grid-cols-10 lg:grid-cols-12 gap-2">
                                    @foreach($questionsList[$sIdx] as $qIdx => $qId)
                                        @php
                                            $isAnswered = isset($answers[$qId]);
                                            $isMarked = in_array($qId, $markedQuestions);
                                            $isVisited = in_array($qId, $visitedQuestions);
                                            $isCurrent = ($currentSectionIndex == $sIdx && $currentQuestionIndex == $qIdx);
                                            $isLocked = !$isVisited && !$isAnswered && !$isMarked && !$isCurrent;
                                            
                                            if ($isAnswered) {
                                                $bgClass = 'bg-[#16a34a] text-white ' . ($isMarked ? 'border-[3px] border-yellow-400' : 'border-[#16a34a]');
                                            } elseif ($isVisited) {
                                                $bgClass = 'bg-gray-200 text-gray-700 ' . ($isMarked ? 'border-[3px] border-yellow-400' : 'border-gray-300');
                                            } else {
                                                $bgClass = 'bg-white text-gray-400 ' . ($isMarked ? 'border-[3px] border-yellow-400' : 'border-gray-300');
                                            }

                                            if ($isCurrent) {
                                                $bgClass = 'ring-2 ring-blue-500 ring-offset-1 ' . $bgClass;
                                            }
                                        @endphp

                                        @if($isLocked)
                                            <div class="h-10 w-full rounded-md border border-gray-100 flex items-center justify-center text-sm font-bold opacity-30 cursor-not-allowed bg-gray-50">
                                                {{ $qIdx + 1 }}
                                            </div>
                                        @else
                                            <button 
                                                wire:click="selectQuestion({{ $sIdx }}, {{ $qIdx }}); $set('showQuestionsModal', false);"
                                                class="h-10 w-full rounded-md flex items-center justify-center text-sm font-bold transition-all hover:scale-105 {{ $bgClass }}"
                                            >
                                                {{ $qIdx + 1 }}
                                            </button>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        {{-- MODAL: INSTRUCTIONS --}}
        @if($showInstructionsModal)
            <div class="fixed inset-0 bg-black/60 z-110 flex items-center justify-center p-6">
                <div class="bg-white rounded-lg w-full max-w-3xl overflow-hidden shadow-2xl flex flex-col max-h-[80vh]">
                    <div class="bg-[#16a34a] p-4 text-white flex justify-between items-center">
                        <h3 class="text-xl font-bold">Test Instructions</h3>
                        <button wire:click="$set('showInstructionsModal', false)" class="text-white hover:text-gray-200">
                            <x-icon name="o-x-mark" class="w-6 h-6" />
                        </button>
                    </div>
                    <div class="p-8 overflow-y-auto prose max-w-none">
                        {!! $test->instruction ?: 'No specific instructions provided for this test.' !!}
                        
                        <div class="mt-8 pt-6 border-t border-gray-100">
                            <h4 class="font-bold text-gray-800 mb-2">Marking Scheme:</h4>
                            <ul class="list-disc pl-5 text-gray-600 space-y-1">
                                <li>Correct Answer: <span class="text-green-600 font-bold">+{{ $test->marks_per_question }}</span></li>
                                <li>Incorrect Answer: <span class="text-red-600 font-bold">-{{ $test->negative_marks }}</span></li>
                                <li>Unattempted: <span class="font-bold">0</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="p-4 bg-gray-50 text-right">
                        <button 
                            wire:click="$set('showInstructionsModal', false)"
                            class="bg-[#16a34a] text-white px-6 py-2 rounded font-bold hover:bg-[#15803d]"
                        >
                            Close Instructions
                        </button>
                    </div>
                </div>
            </div>
        @endif

        {{-- MODAL: SKIP CONFIRMATION --}}
        @if($showSkipConfirmationModal)
            <div class="fixed inset-0 bg-black/60 z-130 flex items-center justify-center p-6 backdrop-blur-sm">
                <div class="bg-white rounded-2xl w-full max-w-md overflow-hidden shadow-2xl flex flex-col">
                    <div class="bg-[#16a34a] p-4 text-white flex justify-between items-center">
                        <h3 class="text-lg font-bold">Confirm Skip</h3>
                        <button wire:click="$set('showSkipConfirmationModal', false)" class="text-white hover:text-gray-200">
                            <x-icon name="o-x-mark" class="w-6 h-6" />
                        </button>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-700 text-sm leading-relaxed mb-6">
                            You have not selected any option for this question. Do you want to skip it and proceed to the next question?
                        </p>
                        <div class="flex gap-4">
                            <button 
                                wire:click="$set('showSkipConfirmationModal', false)"
                                class="flex-1 bg-white border border-gray-200 text-gray-700 py-3 rounded-xl font-bold text-sm hover:bg-gray-50 transition-all cursor-pointer"
                            >
                                Cancel
                            </button>
                            <button 
                                wire:click="confirmSkipAndNext"
                                class="flex-1 bg-[#16a34a] text-white py-3 rounded-xl font-bold text-sm hover:bg-[#15803d] transition-all cursor-pointer"
                            >
                                Yes, Skip
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

</div>
