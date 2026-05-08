<div class="min-h-screen bg-gray-50 flex flex-col">

    {{-- 1. HEADER (Matches Screenshot 2/3 Style) --}}
    <div class="bg-white border-b border-gray-100 shadow-sm px-6 py-4 flex justify-between items-center sticky top-0 z-40">
        <div class="flex items-center gap-6">
            <h2 class="text-2xl font-bold text-success uppercase tracking-tight">{{ $test->title }}</h2>
        </div>
        <div class="flex items-center gap-8 md:gap-16">
            <div class="text-center" wire:ignore x-data="{ 
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
            }">
                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none mb-1">Time Left</div>
                <div class="text-2xl font-bold text-error font-mono tracking-tighter" x-text="timer">00:00:00</div>
            </div>
            <div class="text-center">
                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none mb-1">Total Qs</div>
                <div class="text-2xl font-bold text-gray-900">{{ $totalQuestions }}</div>
            </div>
        </div>
    </div>

    {{-- CONDITIONAL VIEW: Testing vs Review --}}
    @if(!$showSummaryModal)
        {{-- VIEW A: TESTING CONDUCT --}}
        <div class="flex-1 max-w-400 mx-auto w-full p-6 grid grid-cols-1 lg:grid-cols-4 gap-6">
            
            {{-- Main Panel --}}
            <div class="lg:col-span-3 flex flex-col gap-6">
                {{-- Section Tabs --}}
                <div class="flex flex-wrap gap-2">
                    @foreach ($sections as $i => $section)
                        <button 
                            class="px-6 py-2 rounded-lg font-bold text-sm transition-all {{ $currentSectionIndex == $i ? 'bg-success text-white' : 'bg-[#edf5e1] text-success hover:bg-success/10' }}" 
                            wire:click="selectQuestion({{ $i }}, 0)"
                        >
                            {{ $section['section_subject']['name'] }}
                        </button>
                    @endforeach
                </div>

                {{-- Question Card --}}
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8 md:p-12 flex-1">
                    @if ($currentQuestion)
                        <div class="text-error font-bold text-sm uppercase tracking-widest mb-6">Question No {{ $currentQuestionIndex + 1 }}</div>
                        
                        <div class="prose prose-xl max-w-none text-gray-800 mb-12 font-medium">
                            {!! $currentQuestion->question !!}
                        </div>

                        <div class="grid grid-cols-1 gap-4 mb-12">
                            @for ($k = 1; $k <= $currentQuestion->mcq_options; $k++)
                                @php $optKey = 'ans_' . $k; @endphp
                                <label class="flex items-center gap-4 p-5 rounded-2xl border-2 transition-all cursor-pointer {{ ($answers[$currentQuestion->id] ?? '') == $optKey ? 'border-success bg-success/5 shadow-md shadow-success/10' : 'border-gray-50 bg-gray-50/30 hover:border-gray-100 hover:bg-gray-50/50' }}">
                                    <input 
                                        type="radio" 
                                        name="question_{{ $currentQuestion->id }}" 
                                        value="{{ $optKey }}" 
                                        {{ ($answers[$currentQuestion->id] ?? '') == $optKey ? 'checked' : '' }} 
                                        wire:click="saveSelection({{ $currentQuestion->id }}, '{{ $optKey }}')"
                                        class="radio radio-success radio-sm" 
                                    />
                                    <div class="text-gray-700 font-bold">{!! $currentQuestion->$optKey !!}</div>
                                </label>
                            @endfor
                        </div>

                        {{-- Action Buttons (Screenshot 2 Alignment) --}}
                        <div class="flex flex-wrap items-center justify-between gap-4 pt-8 border-t border-gray-50">
                            <div class="flex gap-4">
                                <button 
                                    wire:click="toggleMarkForReview({{ $currentQuestion->id }})"
                                    class="flex items-center gap-2 px-6 py-3 rounded-xl font-bold transition-all {{ in_array($currentQuestion->id, $markedQuestions) ? 'bg-warning text-white' : 'bg-success/5 text-success border border-success/10' }}"
                                >
                                    <x-icon name="{{ in_array($currentQuestion->id, $markedQuestions) ? 's-star' : 'o-star' }}" class="w-5 h-5" />
                                    Mark for Review
                                </button>
                                
                                <button 
                                    wire:click="clearResponse({{ $currentQuestion->id }})" 
                                    class="flex items-center gap-2 px-6 py-3 rounded-xl bg-error/5 text-error font-bold border border-error/10 hover:bg-error/10"
                                >
                                    <x-icon name="o-trash" class="w-5 h-5" />
                                    Clear Response
                                </button>
                            </div>
                            
                            <button 
                                wire:click="saveAndNext"
                                class="bg-success text-white px-10 py-3 rounded-xl font-bold text-lg shadow-lg shadow-success/20 hover:scale-[1.02] active:scale-95 transition-all"
                            >
                                Save & Next
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Sidebar Status Palette --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm flex flex-col overflow-hidden">
                <div class="p-6 bg-[#edf5e1]/50 flex items-center gap-4 border-b border-gray-100">
                    <x-avatar image="{{ '/storage/' . auth()->user()->user_details->photo_url }}" class="w-16! h-16! border-4 border-white shadow-lg rounded-2xl" />
                    <div class="flex-1">
                        <div class="font-bold text-gray-900 leading-none mb-1">{{ auth()->user()->name }}</div>
                        <div class="text-[9px] font-bold text-success uppercase tracking-widest text-wrap">{{ $sections[$currentSectionIndex]['section_subject']['name'] }}</div>
                    </div>
                </div>

                <div class="p-6 flex-1 overflow-y-auto">
                    <div class="grid grid-cols-5 gap-3">
                        @foreach ($questionsList[$currentSectionIndex] ?? [] as $qIndex => $qId)
                            @php
                                $hasAnswer = isset($answers[$qId]);
                                $isMarked = in_array($qId, $markedQuestions);
                                $isVisited = in_array($qId, $this->visitedQuestions);
                                $isCurrent = ($currentQuestion && $currentQuestion->id == $qId);
                                
                                $class = 'bg-gray-100 text-gray-400 border-gray-100'; 
                                if ($hasAnswer) {
                                    $class = 'bg-success text-white border-success';
                                }
                                if ($isMarked) {
                                    $class = 'bg-warning text-white border-warning';
                                }
                                if ($isCurrent) {
                                    $class .= ' ring-4 ring-success ring-offset-2';
                                }
                            @endphp
                            <button 
                                {{-- SERVER-SIDE GUARDED: Also disabled in UI if not visited --}}
                                @if(!$isVisited) disabled @endif
                                class="w-10 h-10 rounded-full flex items-center justify-center text-xs font-bold border transition-all relative
                                {{ $isVisited ? 'hover:scale-110 active:scale-95' : 'opacity-50 cursor-not-allowed' }} 
                                {{ $class }}" 
                                wire:click="selectQuestion({{ $currentSectionIndex }}, {{ $qIndex }})"
                            >
                                {{ $qIndex + 1 }}
                                @if($isMarked)
                                    <div class="absolute -top-1 -right-1 text-warning filter drop-shadow">
                                        <x-icon name="s-star" class="w-4 h-4" />
                                    </div>
                                @endif
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Legend & Submit --}}
                <div class="p-6 border-t border-gray-50 bg-gray-50/30">
                    <div class="flex justify-between text-[10px] font-bold uppercase tracking-tighter mb-6 text-gray-700">
                        <div class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-success"></span> Ans</div>
                        <div class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-gray-300"></span> Skip</div>
                        <div class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-warning"></span> Review</div>
                    </div>
                    
                    <button 
                        wire:click="goToReview"
                        class="w-full bg-success text-white py-3 rounded-xl font-bold text-lg shadow-xl shadow-success/10 hover:bg-success/90"
                    >
                        Review & Submit
                    </button>
                </div>
            </div>
        </div>
    @else
        {{-- VIEW B: REVIEW PAGE (Screenshot 3 Style) --}}
        <div class="flex-1 max-w-5xl mx-auto w-full p-12 bg-white flex flex-col items-center">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full mb-12">
                <div class="bg-gray-50 p-6 rounded-3xl border border-gray-100 flex items-center justify-between">
                    <div>
                        <div class="text-[10px] font-bold text-gray-400 uppercase leading-none mb-2">Attempted</div>
                        <div class="text-3xl font-bold text-success">{{ $attemptedCount }}</div>
                    </div>
                    <span class="w-5 h-5 rounded-full bg-success"></span>
                </div>
                <div class="bg-gray-50 p-6 rounded-3xl border border-gray-100 flex items-center justify-between">
                    <div>
                        <div class="text-[10px] font-bold text-gray-400 uppercase leading-none mb-2">Not Attempted</div>
                        <div class="text-3xl font-bold text-gray-400">{{ $notAttemptedCount }}</div>
                    </div>
                    <span class="w-5 h-5 rounded-full bg-gray-300"></span>
                </div>
                <div class="bg-gray-50 p-6 rounded-3xl border border-gray-100 flex items-center justify-between">
                    <div>
                        <div class="text-[10px] font-bold text-gray-400 uppercase leading-none mb-2">For Review</div>
                        <div class="text-3xl font-bold text-warning">{{ $reviewCount }}</div>
                    </div>
                    <div class="text-warning"><x-icon name="s-star" class="w-5 h-5" /></div>
                </div>
            </div>

            <div class="w-full border-2 border-gray-100 rounded-[2.5rem] p-12 mb-12 overflow-hidden shadow-inner">
                <div class="flex flex-wrap gap-4 justify-center">
                    @php $globalIndex = 1; @endphp
                    @foreach ($questionsList as $secIndex => $qIds)
                        @foreach($qIds as $qId)
                            @php
                                $hasAnswer = isset($answers[$qId]);
                                $isMarked = in_array($qId, $markedQuestions);
                                
                                $class = 'bg-gray-100 text-gray-300 border-gray-100'; 
                                if ($hasAnswer) { $class = 'bg-success text-white border-success'; }
                                if ($isMarked) { $class = 'bg-warning text-white border-warning'; }
                            @endphp
                            <button 
                                wire:click="reviewSelectQuestion({{ $secIndex }}, {{ $loop->index }})"
                                class="w-12 h-12 rounded-full flex items-center justify-center font-bold relative transition-all hover:scale-110 active:scale-95
                                {{ $isMarked ? 'shadow-lg shadow-warning/20' : '' }}
                                {{ $class }}" 
                            >
                                {{ $globalIndex++ }}
                                @if($isMarked)
                                    <div class="absolute -top-1 -right-1 text-white filter drop-shadow">
                                        <x-icon name="s-star" class="w-4 h-4" />
                                    </div>
                                @endif
                            </button>
                        @endforeach
                    @endforeach
                </div>
            </div>

            <button 
                wire:click="submitTest"
                class="bg-success text-white px-20 py-4 rounded-2xl font-bold text-2xl shadow-2xl shadow-success/20 hover:scale-105 active:scale-95 transition-all"
            >
                Final Submit
            </button>
            <button wire:click="toggleSummaryModal" class="mt-6 text-gray-400 font-bold hover:text-gray-900">Back to test</button>
        </div>
    @endif

    {{-- Anti-cheat Script --}}
    @script
    <script>
        window.onbeforeunload = function() {
            return "Are you sure you want to leave? Your progress is saved!";
        };
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.go(1);
        };
    </script>
    @endscript
</div>
