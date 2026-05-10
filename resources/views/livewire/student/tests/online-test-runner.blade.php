<div class="min-h-screen bg-white flex flex-col font-sans" wire:ignore.self>

    {{-- 1. TOP HEADER (Screenshot Match) --}}
    <div class="bg-white px-8 py-6 flex justify-between items-center border-b border-gray-50 sticky top-0 z-50">
        <div class="flex items-center">
            <h2 class="text-4xl font-black text-success uppercase tracking-tighter">{{ $test->title }}</h2>
        </div>
        <div class="flex items-center gap-12">
            <div class="flex items-center gap-3">
                <div class="text-2xl font-black text-gray-900">Time Left :</div>
                <div class="text-3xl font-black text-error font-mono" x-data="{ 
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
            <div class="flex items-center gap-3">
                <div class="text-2xl font-black text-gray-900">Qs:</div>
                <div class="text-3xl font-black text-gray-900">{{ $totalQuestions }}</div>
            </div>
        </div>
    </div>

    @if(!$showSummaryModal)
        {{-- VIEW A: TESTING CONDUCT --}}
        <div class="flex-1 p-8 grid grid-cols-1 lg:grid-cols-4 gap-12">
            
            {{-- Main Question Area --}}
            <div class="lg:col-span-3 flex flex-col gap-6">
                @if ($currentQuestion)
                    <div class="text-2xl font-black text-error mb-2 uppercase">Question No {{ $currentQuestionIndex + 1 }}</div>
                    
                    {{-- Section Tabs --}}
                    <div class="flex flex-wrap gap-3 mb-4">
                        @foreach ($sections as $i => $section)
                            <button 
                                wire:key="sec-tab-{{ $i }}"
                                class="px-8 py-3 rounded-md font-black text-lg transition-all {{ $currentSectionIndex == $i ? 'bg-success text-white shadow-md' : 'bg-[#74b38a] text-white' }}" 
                                wire:click="selectQuestion({{ $i }}, 0)"
                            >
                                {{ $section['section_subject']['name'] }}
                            </button>
                        @endforeach
                    </div>

                    <div class="flex-1">
                        <div class="prose prose-2xl max-w-none text-gray-800 mb-10 font-bold leading-snug">
                            Qs {{ $currentQuestionIndex + 1 }}- {!! $currentQuestion->question !!}
                        </div>

                        <div class="grid grid-cols-1 gap-4 mb-10" wire:key="opts-{{ $currentQuestion->id }}">
                            @for ($k = 1; $k <= $currentQuestion->mcq_options; $k++)
                                @php $optKey = 'ans_' . $k; @endphp
                                <label class="flex items-center gap-4 cursor-pointer group">
                                    <input 
                                        type="radio" 
                                        name="q_{{ $currentQuestion->id }}" 
                                        wire:key="opt-{{ $currentQuestion->id }}-{{ $k }}"
                                        value="{{ $optKey }}" 
                                        {{ ($answers[$currentQuestion->id] ?? '') == $optKey ? 'checked' : '' }} 
                                        wire:click="saveSelection({{ $currentQuestion->id }}, '{{ $optKey }}')"
                                        class="radio radio-success radio-lg border-2 border-gray-400" 
                                    />
                                    <div class="text-xl font-bold text-gray-700 group-hover:text-gray-900">{!! $currentQuestion->$optKey !!}</div>
                                </label>
                            @endfor
                        </div>

                        {{-- Action Buttons (Screenshot Bottom Bar Match) --}}
                        <div class="flex flex-wrap items-center gap-4 pt-10 border-t border-gray-100">
                            <button 
                                wire:click="toggleMarkForReview({{ $currentQuestion->id }})"
                                class="flex items-center gap-2 px-8 py-3 rounded-md bg-success text-white font-black text-xl hover:bg-success/90 transition-all shadow-md"
                            >
                                <x-icon name="s-star" class="w-6 h-6 text-warning" />
                                Mark for Review
                            </button>
                            
                            <button 
                                wire:click="clearResponse({{ $currentQuestion->id }})" 
                                class="flex items-center gap-2 px-8 py-3 rounded-md bg-success text-white font-black text-xl hover:bg-success/90 transition-all shadow-md"
                            >
                                <x-icon name="o-trash" class="w-6 h-6" />
                                Clear Response
                            </button>

                            <button 
                                wire:click="saveAndNext"
                                class="flex items-center gap-2 px-8 py-3 rounded-md bg-success text-white font-black text-xl hover:bg-success/90 transition-all shadow-md ml-auto"
                            >
                                <x-icon name="o-arrow-right-circle" class="w-6 h-6" />
                                Save & Next
                            </button>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Sidebar (Screenshot Match) --}}
            <div class="bg-white border-2 border-success/30 flex flex-col h-fit sticky top-24 rounded-md shadow-lg overflow-hidden">
                <div class="p-4 bg-white flex items-center gap-4">
                    <div class="w-20 h-20 rounded-full border-2 border-gray-50 shadow-sm overflow-hidden bg-gray-100">
                         <img src="{{ '/storage/' . auth()->user()->user_details->photo_url }}" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1">
                        <div class="text-2xl font-black text-gray-900 leading-tight uppercase">{{ auth()->user()->name }}</div>
                    </div>
                </div>

                <div class="bg-success py-2 px-4 text-center">
                    <span class="text-white text-2xl font-black uppercase tracking-widest">
                        {{ $sections[$currentSectionIndex]['section_subject']['name'] }}
                    </span>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-5 gap-3 mb-8">
                        @foreach ($questionsList[$currentSectionIndex] ?? [] as $qIndex => $qId)
                            @php
                                $hasAnswer = isset($answers[$qId]);
                                $isMarked = in_array($qId, $markedQuestions);
                                $isVisited = in_array($qId, $this->visitedQuestions);
                                $isCurrent = ($currentQuestion && $currentQuestion->id == $qId);
                                
                                $class = 'bg-white text-gray-900 border-gray-400'; 
                                if ($hasAnswer) {
                                    $class = 'bg-success text-white border-success';
                                }
                                if ($isMarked) {
                                    $class = 'bg-success/20 text-success border-success/30';
                                }
                                if ($isCurrent) {
                                    $class .= ' ring-4 ring-success/20 ring-offset-2';
                                }
                            @endphp
                            <button 
                                wire:key="pal-{{ $qId }}"
                                @if(!$isVisited) disabled @endif
                                class="w-12 h-12 rounded-full flex items-center justify-center text-xl font-bold border transition-all relative
                                {{ $isVisited ? 'hover:bg-success/5' : 'opacity-40 cursor-not-allowed' }} 
                                {{ $class }}" 
                                wire:click="selectQuestion({{ $currentSectionIndex }}, {{ $qIndex }})"
                            >
                                {{ $qIndex + 1 }}
                                @if($isMarked)
                                    <div class="absolute -top-1.5 -right-1.5 text-warning filter drop-shadow-sm">
                                        <x-icon name="s-star" class="w-5 h-5" />
                                    </div>
                                @endif
                            </button>
                        @endforeach
                    </div>

                    <div class="flex justify-between items-center border-t border-success/20 pt-4">
                        <button class="text-success font-black text-lg hover:underline uppercase">Questions List</button>
                        <button class="text-success font-black text-lg hover:underline uppercase">Instructions</button>
                    </div>
                </div>

                <div class="p-4 bg-white">
                    <button 
                        wire:click="goToReview"
                        class="w-full bg-success text-white py-4 rounded-md font-black text-2xl shadow-xl hover:bg-success/90 transition-all uppercase tracking-tighter"
                    >
                        Review & Submit
                    </button>
                </div>
            </div>
        </div>
    @else
        {{-- VIEW B: SUMMARY MODAL --}}
        <div class="fixed inset-0 bg-black/60 backdrop-blur-md z-[100] flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl w-full max-w-4xl overflow-hidden shadow-2xl animate-in zoom-in duration-300">
                <div class="bg-success p-10 text-white flex justify-between items-center">
                    <div>
                        <h2 class="text-5xl font-black uppercase tracking-tighter mb-2">Test Summary</h2>
                        <p class="text-xl font-bold opacity-80 uppercase tracking-widest">{{ $test->title }}</p>
                    </div>
                    <x-icon name="o-clipboard-document-check" class="w-24 h-24 opacity-20" />
                </div>

                <div class="p-10">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                        <div class="bg-gray-50 p-8 rounded-2xl border border-gray-100 text-center">
                            <div class="text-5xl font-black text-gray-900 mb-2">{{ $totalQuestions }}</div>
                            <div class="text-xs font-black text-gray-400 uppercase tracking-widest">Total Qs</div>
                        </div>
                        <div class="bg-success/10 p-8 rounded-2xl border border-success/20 text-center">
                            <div class="text-5xl font-black text-success mb-2">{{ count($answers) }}</div>
                            <div class="text-xs font-black text-success uppercase tracking-widest">Attempted</div>
                        </div>
                        <div class="bg-error/10 p-8 rounded-2xl border border-error/20 text-center">
                            <div class="text-5xl font-black text-error mb-2">{{ $totalQuestions - count($answers) }}</div>
                            <div class="text-xs font-black text-error uppercase tracking-widest">Not Attempted</div>
                        </div>
                        <div class="bg-warning/10 p-8 rounded-2xl border border-warning/20 text-center">
                            <div class="text-5xl font-black text-warning mb-2">{{ count($markedQuestions) }}</div>
                            <div class="text-xs font-black text-warning uppercase tracking-widest">For Review</div>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <button 
                            wire:click="$set('showSummaryModal', false)"
                            class="flex-1 bg-gray-100 text-gray-700 py-6 rounded-2xl font-black text-xl hover:bg-gray-200 transition-all uppercase tracking-tight"
                        >
                            Return to Test
                        </button>
                        <button 
                            wire:click="submitTest"
                            class="flex-[2] bg-success text-white py-6 rounded-2xl font-black text-2xl shadow-xl hover:bg-success/90 transition-all uppercase tracking-tight"
                        >
                            Submit Test Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
