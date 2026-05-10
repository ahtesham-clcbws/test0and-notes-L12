<div class="min-h-screen bg-white flex flex-col font-sans" wire:ignore.self>

    {{-- 1. TOP HEADER (100% Mockup Match) --}}
    <div class="bg-white px-10 py-8 flex justify-between items-center border-b border-gray-100 sticky top-0 z-50">
        <div class="flex items-center">
            <h1 class="text-4xl font-black text-success uppercase tracking-tighter">{{ $test->title }}</h1>
        </div>
        <div class="flex items-center gap-20">
            <div class="flex items-center gap-4">
                <div class="text-3xl font-black text-error">Time Left :</div>
                <div class="text-4xl font-black text-error font-mono" x-data="{ 
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
                }" x-text="timer">00:00:00</div>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-3xl font-black text-gray-900">Qs:</div>
                <div class="text-4xl font-black text-gray-900">{{ $totalQuestions }}</div>
            </div>
        </div>
    </div>

    @if(!$showSummaryModal)
        {{-- VIEW A: TESTING CONDUCT --}}
        <div class="flex-1 px-10 py-8 grid grid-cols-1 lg:grid-cols-4 gap-12 w-full">
            
            {{-- Left Column: Question Area --}}
            <div class="lg:col-span-3 flex flex-col">
                @if ($currentQuestion)
                    <div class="text-2xl font-black text-error uppercase tracking-tight mb-8">Question No {{ $currentQuestionIndex + 1 }}</div>
                    
                    {{-- Section Tabs --}}
                    <div class="flex flex-wrap gap-4 mb-10">
                        @foreach ($sections as $i => $section)
                            <button 
                                wire:key="sec-{{ $i }}"
                                class="px-10 py-3 rounded-md font-black text-xl transition-all {{ $currentSectionIndex == $i ? 'bg-success text-white shadow-md' : 'bg-[#74b38a] text-white opacity-80' }}" 
                                wire:click="selectQuestion({{ $i }}, 0)"
                            >
                                {{ $section['section_subject']['name'] }}
                            </button>
                        @endforeach
                        <div class="ml-auto flex items-center">
                            <input type="checkbox" class="w-8 h-8 border-2 border-gray-400 rounded-sm" />
                        </div>
                    </div>

                    <div class="flex-1">
                        <div class="prose prose-2xl max-w-none text-gray-900 mb-12 font-bold leading-relaxed">
                            Qs {{ $currentQuestionIndex + 1 }}- {!! $currentQuestion->question !!}
                        </div>

                        <div class="grid grid-cols-1 gap-6 mb-20" wire:key="options-{{ $currentQuestion->id }}">
                            @for ($k = 1; $k <= $currentQuestion->mcq_options; $k++)
                                @php $optKey = 'ans_' . $k; @endphp
                                <label class="flex items-center gap-6 cursor-pointer group">
                                    <input 
                                        type="radio" 
                                        name="q_{{ $currentQuestion->id }}" 
                                        wire:key="opt-{{ $currentQuestion->id }}-{{ $k }}"
                                        value="{{ $optKey }}" 
                                        {{ ($answers[$currentQuestion->id] ?? '') == $optKey ? 'checked' : '' }} 
                                        wire:click="saveSelection({{ $currentQuestion->id }}, '{{ $optKey }}')"
                                        class="radio radio-success radio-lg border-2 border-gray-400" 
                                    />
                                    <div class="text-2xl font-bold text-gray-700 group-hover:text-gray-900">{!! $currentQuestion->$optKey !!}</div>
                                </label>
                            @endfor
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex flex-wrap items-center gap-6 pt-10 border-t border-gray-100">
                            <button 
                                wire:click="toggleMarkForReview({{ $currentQuestion->id }})"
                                class="flex items-center gap-3 px-10 py-3 rounded-md bg-success text-white font-black text-2xl hover:bg-success/90 transition-all shadow-md"
                            >
                                <x-icon name="s-star" class="w-8 h-8 text-warning" />
                                Mark for Review
                            </button>
                            
                            <button 
                                wire:click="clearResponse({{ $currentQuestion->id }})" 
                                class="flex items-center gap-3 px-10 py-3 rounded-md bg-success text-white font-black text-2xl hover:bg-success/90 transition-all shadow-md"
                            >
                                <x-icon name="o-trash" class="w-8 h-8" />
                                Clear Response
                            </button>

                            <button 
                                wire:click="saveAndNext"
                                class="flex items-center gap-3 px-10 py-3 rounded-md bg-success text-white font-black text-2xl hover:bg-success/90 transition-all shadow-md ml-auto"
                            >
                                <x-icon name="o-arrow-right-circle" class="w-8 h-8" />
                                Save & Next
                            </button>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Right Column: Sidebar (100% Mockup Structure) --}}
            <div class="border-2 border-gray-100 flex flex-col h-fit sticky top-32 rounded-xl shadow-xl overflow-hidden bg-white">
                {{-- Profile Section --}}
                <div class="flex items-stretch">
                    <div class="bg-gray-100 p-4 flex items-center justify-center border-r border-gray-200">
                        <div class="w-24 h-24 rounded-full overflow-hidden border-2 border-white shadow-sm">
                             <img src="{{ '/storage/' . auth()->user()->user_details->photo_url }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div class="flex-1 bg-[#f8f9fa] flex items-center px-6 border-b border-gray-200">
                        <div class="text-3xl font-black text-gray-900 leading-tight uppercase tracking-tight">{{ auth()->user()->name }}</div>
                    </div>
                </div>

                {{-- Section Title Banner --}}
                <div class="bg-success py-4 px-6 text-center">
                    <span class="text-white text-3xl font-black uppercase tracking-widest">
                        {{ $sections[$currentSectionIndex]['section_subject']['name'] }}
                    </span>
                </div>

                {{-- Palette Grid --}}
                <div class="p-8">
                    <div class="grid grid-cols-5 gap-4 mb-10">
                        @foreach ($questionsList[$currentSectionIndex] ?? [] as $qIndex => $qId)
                            @php
                                $hasAnswer = isset($answers[$qId]);
                                $isMarked = in_array($qId, $markedQuestions);
                                $isVisited = in_array($qId, $this->visitedQuestions);
                                $isCurrent = ($currentQuestion && $currentQuestion->id == $qId);
                                
                                $class = 'bg-white text-gray-900 border-gray-300'; 
                                if ($hasAnswer) {
                                    $class = 'bg-success text-white border-success';
                                }
                                if ($isMarked) {
                                    $class = 'bg-success/20 text-success border-success/30';
                                }
                                if ($isCurrent) {
                                    $class .= ' ring-4 ring-success/20 ring-offset-4';
                                }
                            @endphp
                            <button 
                                wire:key="pal-{{ $qId }}"
                                @if(!$isVisited) disabled @endif
                                class="w-14 h-14 rounded-full flex items-center justify-center text-2xl font-black border transition-all relative
                                {{ $isVisited ? 'hover:bg-success/5' : 'opacity-40 cursor-not-allowed' }} 
                                {{ $class }}" 
                                wire:click="selectQuestion({{ $currentSectionIndex }}, {{ $qIndex }})"
                            >
                                {{ $qIndex + 1 }}
                                @if($isMarked)
                                    <div class="absolute -top-2 -right-2 text-warning filter drop-shadow-sm">
                                        <x-icon name="s-star" class="w-6 h-6" />
                                    </div>
                                @endif
                            </button>
                        @endforeach
                    </div>

                    {{-- Navigation Links --}}
                    <div class="flex justify-between items-center border-t border-gray-100 pt-6">
                        <button class="text-success font-black text-xl hover:underline uppercase tracking-tight">Questions List</button>
                        <button class="text-success font-black text-xl hover:underline uppercase tracking-tight">Instructions</button>
                    </div>
                </div>

                {{-- Submit Block --}}
                <div class="p-6 bg-white border-t border-gray-100">
                    <button 
                        wire:click="goToReview"
                        class="w-full bg-success text-white py-5 rounded-md font-black text-3xl shadow-xl hover:bg-success/90 transition-all uppercase tracking-tighter"
                    >
                        Review & Submit
                    </button>
                </div>
            </div>
        </div>
    @else
        {{-- VIEW B: SUMMARY MODAL --}}
        <div class="fixed inset-0 bg-black/60 backdrop-blur-md z-[100] flex items-center justify-center p-6">
            <div class="bg-white rounded-[4rem] w-full max-w-5xl overflow-hidden shadow-2xl animate-in zoom-in duration-300">
                <div class="bg-success p-12 text-white flex justify-between items-center">
                    <div>
                        <h2 class="text-6xl font-black uppercase tracking-tighter mb-4">Summary</h2>
                        <p class="text-2xl font-bold opacity-80 uppercase tracking-widest">{{ $test->title }}</p>
                    </div>
                    <x-icon name="o-clipboard-document-check" class="w-32 h-32 opacity-20" />
                </div>

                <div class="p-16">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-16">
                        <div class="bg-gray-50 p-10 rounded-3xl border border-gray-100 text-center">
                            <div class="text-6xl font-black text-gray-900 mb-2">{{ $totalQuestions }}</div>
                            <div class="text-sm font-black text-gray-400 uppercase tracking-widest">Total Qs</div>
                        </div>
                        <div class="bg-success/10 p-10 rounded-3xl border border-success/20 text-center">
                            <div class="text-6xl font-black text-success mb-2">{{ count($answers) }}</div>
                            <div class="text-sm font-black text-success uppercase tracking-widest">Attempted</div>
                        </div>
                        <div class="bg-error/10 p-10 rounded-3xl border border-error/20 text-center">
                            <div class="text-6xl font-black text-error mb-2">{{ $totalQuestions - count($answers) }}</div>
                            <div class="text-sm font-black text-error uppercase tracking-widest">Not Attempted</div>
                        </div>
                        <div class="bg-warning/10 p-10 rounded-3xl border border-warning/20 text-center">
                            <div class="text-6xl font-black text-warning mb-2">{{ count($markedQuestions) }}</div>
                            <div class="text-sm font-black text-warning uppercase tracking-widest">For Review</div>
                        </div>
                    </div>

                    <div class="flex gap-6">
                        <button 
                            wire:click="$set('showSummaryModal', false)"
                            class="flex-1 bg-gray-100 text-gray-700 py-8 rounded-3xl font-black text-2xl hover:bg-gray-200 transition-all uppercase tracking-tight"
                        >
                            Back
                        </button>
                        <button 
                            wire:click="submitTest"
                            class="flex-[2] bg-success text-white py-8 rounded-3xl font-black text-3xl shadow-2xl hover:bg-success/90 transition-all uppercase tracking-tight"
                        >
                            Confirm Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
