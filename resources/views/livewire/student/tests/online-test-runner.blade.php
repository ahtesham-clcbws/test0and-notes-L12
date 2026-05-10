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

    @if(!$showSummaryModal)
        {{-- VIEW A: TESTING CONDUCT --}}
        <div class="flex-1 flex px-8 py-6 gap-8 w-full max-w-[1600px] mx-auto">
            
            {{-- Left Column: Question Area --}}
            <div class="flex-1 flex flex-col">
                @if ($currentQuestion)
                    <h2 class="text-[#dc2626] font-bold text-lg mb-4">Question No {{ $currentQuestionIndex + 1 }}</h2>
                    
                    {{-- Section Tabs --}}
                    <div class="flex items-center gap-2 mb-6 border-b border-gray-200 pb-2">
                        @foreach ($sections as $i => $section)
                            <button 
                                wire:key="sec-{{ $i }}"
                                class="px-4 py-2 font-bold text-sm transition-colors {{ $currentSectionIndex == $i ? 'bg-[#16a34a] text-white' : 'bg-[#94b4a4] text-gray-800 hover:bg-[#7fa391]' }}" 
                                wire:click="selectQuestion({{ $i }}, 0)"
                            >
                                {{ $section['section_subject']['name'] }}
                            </button>
                        @endforeach
                        <div class="ml-auto">
                            <input type="checkbox" class="w-6 h-6 border-gray-400 rounded-sm cursor-not-allowed opacity-50" disabled />
                        </div>
                    </div>

                    {{-- Question Content --}}
                    <div class="flex-1 overflow-y-auto pr-4 mb-6">
                        <div class="text-base text-gray-800 mb-6 leading-relaxed">
                            Qs {{ $currentQuestionIndex + 1 }}- {!! $currentQuestion->question !!}
                        </div>

                        <div class="flex flex-col gap-3" wire:key="options-{{ $currentQuestion->id }}">
                            @for ($k = 1; $k <= $currentQuestion->mcq_options; $k++)
                                @php $optKey = 'ans_' . $k; @endphp
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input 
                                        type="radio" 
                                        name="q_{{ $currentQuestion->id }}" 
                                        wire:key="opt-{{ $currentQuestion->id }}-{{ $k }}"
                                        value="{{ $optKey }}" 
                                        {{ ($answers[$currentQuestion->id] ?? '') == $optKey ? 'checked' : '' }} 
                                        wire:click="saveSelection({{ $currentQuestion->id }}, '{{ $optKey }}')"
                                        class="mt-1 w-4 h-4 text-[#16a34a] border-gray-400 focus:ring-[#16a34a]" 
                                    />
                                    <div class="text-sm text-gray-700 leading-snug pt-0.5">{!! $currentQuestion->$optKey !!}</div>
                                </label>
                            @endfor
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="pt-4 flex items-center justify-between border-t border-gray-200 mt-6">
                        <div class="flex gap-2">
                            <button 
                                wire:click="toggleMarkForReview({{ $currentQuestion->id }})"
                                class="bg-[#16a34a] text-white px-5 py-2 font-bold text-sm flex items-center gap-2 hover:bg-[#15803d] transition-colors"
                            >
                                <x-icon name="s-star" class="w-5 h-5 text-yellow-300" />
                                Mark for Review
                            </button>
                            
                            <button 
                                wire:click="clearResponse({{ $currentQuestion->id }})" 
                                class="bg-[#94b4a4] text-white px-5 py-2 font-bold text-sm flex items-center gap-2 hover:bg-[#7fa391] transition-colors"
                            >
                                <x-icon name="o-trash" class="w-5 h-5 text-red-500" />
                                Clear Response
                            </button>
                        </div>

                        <button 
                            wire:click="saveAndNext"
                            class="bg-[#16a34a] text-white px-6 py-2 font-bold text-sm flex items-center gap-2 hover:bg-[#15803d] transition-colors"
                        >
                            <x-icon name="o-arrow-right-circle" class="w-5 h-5" />
                            Save & Next
                        </button>
                    </div>
                @endif
            </div>

            {{-- Right Column: Sidebar (Exact Mockup Match) --}}
            <div class="w-80 border border-[#16a34a] flex flex-col h-fit self-start shrink-0 bg-white">
                
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
                    <span class="font-bold text-lg">
                        {{ $sections[$currentSectionIndex]['section_subject']['name'] }}
                    </span>
                </div>

                {{-- Palette Grid --}}
                <div class="p-4 bg-white">
                    <div class="grid grid-cols-5 gap-2 mb-8">
                        @foreach ($questionsList[$currentSectionIndex] ?? [] as $qIndex => $qId)
                            @php
                                $hasAnswer = isset($answers[$qId]);
                                $isMarked = in_array($qId, $markedQuestions);
                                $isVisited = in_array($qId, $this->visitedQuestions);
                                $isCurrent = ($currentQuestion && $currentQuestion->id == $qId);
                                
                                // Default (Not Visited): Gray border, white background
                                $class = 'bg-white text-gray-800 border-gray-400'; 
                                
                                if ($hasAnswer) {
                                    // Answered: Solid Green
                                    $class = 'bg-[#16a34a] text-white border-[#16a34a]';
                                } elseif ($isVisited && !$hasAnswer) {
                                    // Visited but not answered: White background with red border? 
                                    // Based on standard test UI, visited and unanswered is usually red.
                                    // Wait, mockup shows mostly white circles with grey border. Let's stick to gray.
                                    $class = 'bg-white text-gray-800 border-gray-400';
                                }

                                if ($isCurrent) {
                                    // Add subtle ring for current
                                    $class .= ' ring-2 ring-[#16a34a]/30';
                                }
                            @endphp
                            <button 
                                wire:key="pal-{{ $qId }}"
                                @if(!$isVisited && !$isCurrent && !$hasAnswer && !$isMarked) 
                                    {{-- Allow clicking anything based on requirement? Most exams allow free navigation. --}}
                                @endif
                                class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold border transition-all relative {{ $class }}" 
                                wire:click="selectQuestion({{ $currentSectionIndex }}, {{ $qIndex }})"
                            >
                                {{ $qIndex + 1 }}
                                @if($isMarked)
                                    <div class="absolute -top-1 -right-1">
                                        <x-icon name="s-star" class="w-4 h-4 text-yellow-400 filter drop-shadow-sm" />
                                    </div>
                                @endif
                            </button>
                        @endforeach
                    </div>

                    {{-- Navigation Links --}}
                    <div class="flex justify-between items-center border-t border-gray-200 pt-3 px-2">
                        <button class="text-[#16a34a] font-bold text-xs hover:underline">Questions List</button>
                        <button class="text-[#16a34a] font-bold text-xs hover:underline">Instructions</button>
                    </div>
                </div>

                {{-- Submit Block --}}
                <button 
                    wire:click="goToReview"
                    class="w-full bg-[#16a34a] text-white py-3 font-bold text-lg hover:bg-[#15803d] transition-colors"
                >
                    Review & Submit
                </button>
            </div>
        </div>
    @else
        {{-- VIEW B: SUMMARY MODAL --}}
        <div class="fixed inset-0 bg-black/60 z-[100] flex items-center justify-center p-6">
            <div class="bg-white rounded-lg w-full max-w-4xl overflow-hidden shadow-2xl">
                <div class="bg-[#16a34a] p-6 text-white flex justify-between items-center">
                    <div>
                        <h2 class="text-3xl font-bold mb-1">Final Summary</h2>
                        <p class="text-lg opacity-90">{{ $test->title }}</p>
                    </div>
                </div>

                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 text-center">
                            <div class="text-4xl font-bold text-gray-900 mb-2">{{ $totalQuestions }}</div>
                            <div class="text-xs font-bold text-gray-500 uppercase tracking-widest">Total Qs</div>
                        </div>
                        <div class="bg-green-50 p-6 rounded-lg border border-green-200 text-center">
                            <div class="text-4xl font-bold text-[#16a34a] mb-2">{{ count($answers) }}</div>
                            <div class="text-xs font-bold text-[#16a34a] uppercase tracking-widest">Attempted</div>
                        </div>
                        <div class="bg-red-50 p-6 rounded-lg border border-red-200 text-center">
                            <div class="text-4xl font-bold text-red-600 mb-2">{{ $totalQuestions - count($answers) }}</div>
                            <div class="text-xs font-bold text-red-600 uppercase tracking-widest">Not Attempted</div>
                        </div>
                        <div class="bg-yellow-50 p-6 rounded-lg border border-yellow-200 text-center">
                            <div class="text-4xl font-bold text-yellow-600 mb-2">{{ count($markedQuestions) }}</div>
                            <div class="text-xs font-bold text-yellow-600 uppercase tracking-widest">For Review</div>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <button 
                            wire:click="$set('showSummaryModal', false)"
                            class="flex-1 bg-gray-200 text-gray-800 py-4 rounded-md font-bold text-lg hover:bg-gray-300 transition-colors"
                        >
                            Return to Test
                        </button>
                        <button 
                            wire:click="submitTest"
                            class="flex-[2] bg-[#16a34a] text-white py-4 rounded-md font-bold text-xl shadow-md hover:bg-[#15803d] transition-colors"
                        >
                            Submit Test Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
