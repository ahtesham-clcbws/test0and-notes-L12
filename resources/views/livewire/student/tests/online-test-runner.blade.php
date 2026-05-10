<div class="min-h-screen bg-gray-50 flex flex-col">

    <div class="bg-white border-b border-gray-100 shadow-sm px-6 py-3 flex justify-between items-center sticky top-0 z-40">
        <div class="flex items-center gap-6">
            <h2 class="text-3xl font-extrabold text-success uppercase tracking-tighter">{{ $test->title }}</h2>
        </div>
        <div class="flex items-center gap-10">
            <div class="flex items-center gap-2">
                <div class="text-lg font-bold text-gray-900">Time Left :</div>
                <div class="text-2xl font-bold text-error font-mono" x-text="timer">00:00:00</div>
            </div>
            <div class="flex items-center gap-2">
                <div class="text-lg font-bold text-gray-900">Qs:</div>
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
                            wire:key="section-{{ $i }}"
                            class="px-6 py-2 rounded-md font-bold text-sm transition-all {{ $currentSectionIndex == $i ? 'bg-success text-white shadow-md' : 'bg-success/20 text-success hover:bg-success/30' }}" 
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

                        <div class="grid grid-cols-1 gap-3 mb-10" wire:key="q-options-{{ $currentQuestion->id }}">
                            @for ($k = 1; $k <= $currentQuestion->mcq_options; $k++)
                                @php $optKey = 'ans_' . $k; @endphp
                                <label class="flex items-center gap-3 p-3 rounded-xl border-2 transition-all cursor-pointer {{ ($answers[$currentQuestion->id] ?? '') == $optKey ? 'border-success bg-success/5 shadow-sm' : 'border-gray-50 bg-gray-50/20 hover:bg-gray-50/50' }}">
                                    <input 
                                        type="radio" 
                                        name="q_{{ $currentQuestion->id }}" 
                                        wire:key="opt-{{ $currentQuestion->id }}-{{ $k }}"
                                        value="{{ $optKey }}" 
                                        {{ ($answers[$currentQuestion->id] ?? '') == $optKey ? 'checked' : '' }} 
                                        wire:click="saveSelection({{ $currentQuestion->id }}, '{{ $optKey }}')"
                                        class="radio radio-success radio-md" 
                                    />
                                    <div class="text-gray-700 font-semibold">{!! $currentQuestion->$optKey !!}</div>
                                </label>
                            @endfor
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex flex-wrap items-center justify-between gap-4 pt-6 border-t border-gray-100">
                            <div class="flex gap-3">
                                <button 
                                    wire:click="toggleMarkForReview({{ $currentQuestion->id }})"
                                    class="flex items-center gap-2 px-5 py-2.5 rounded-md font-bold transition-all {{ in_array($currentQuestion->id, $markedQuestions) ? 'bg-warning text-white' : 'bg-success text-white' }}"
                                >
                                    <x-icon name="{{ in_array($currentQuestion->id, $markedQuestions) ? 's-star' : 'o-star' }}" class="w-4 h-4" />
                                    Mark for Review
                                </button>
                                
                                <button 
                                    wire:click="clearResponse({{ $currentQuestion->id }})" 
                                    class="flex items-center gap-2 px-5 py-2.5 rounded-md bg-success text-white font-bold transition-all hover:bg-success/90"
                                >
                                    <x-icon name="o-trash" class="w-4 h-4" />
                                    Clear Response
                                </button>
                            </div>
                            
                            <button 
                                wire:click="saveAndNext"
                                class="bg-success text-white px-8 py-2.5 rounded-md font-bold text-lg shadow-md hover:bg-success/90 flex items-center gap-2"
                            >
                                <x-icon name="o-arrow-right-circle" class="w-5 h-5" />
                                Save & Next
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Sidebar Status Palette --}}
            <div class="bg-white border-2 border-success/30 flex flex-col h-fit sticky top-24 overflow-hidden rounded-md">
                <div class="p-4 bg-success/10 flex items-center gap-3 border-b-2 border-success/20">
                    <x-avatar image="{{ '/storage/' . auth()->user()->user_details->photo_url }}" class="w-14! h-14! border-2 border-white shadow rounded-full" />
                    <div class="flex-1">
                        <div class="font-extrabold text-gray-900 leading-none mb-1">{{ auth()->user()->name }}</div>
                        <div class="bg-success text-white text-[10px] font-bold px-2 py-0.5 rounded inline-block uppercase tracking-wider">
                            {{ $sections[$currentSectionIndex]['section_subject']['name'] }}
                        </div>
                    </div>
                </div>

                <div class="p-4 flex-1">
                    <div class="grid grid-cols-5 gap-2.5 max-h-[400px] overflow-y-auto pr-1">
                        @foreach ($questionsList[$currentSectionIndex] ?? [] as $qIndex => $qId)
                            @php
                                $hasAnswer = isset($answers[$qId]);
                                $isMarked = in_array($qId, $markedQuestions);
                                $isVisited = in_array($qId, $this->visitedQuestions);
                                $isCurrent = ($currentQuestion && $currentQuestion->id == $qId);
                                
                                $class = 'bg-white text-gray-600 border-gray-300'; 
                                if ($hasAnswer) {
                                    $class = 'bg-success text-white border-success';
                                } elseif ($isVisited) {
                                    $class = 'bg-gray-100 text-gray-400 border-gray-200';
                                }
                                if ($isMarked) {
                                    $class = 'bg-success/20 text-success border-success/40';
                                }
                                if ($isCurrent) {
                                    $class .= ' ring-2 ring-success ring-offset-1';
                                }
                            @endphp
                            <button 
                                wire:key="palette-{{ $qId }}"
                                @if(!$isVisited) disabled @endif
                                class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold border-2 transition-all relative
                                {{ $isVisited ? 'hover:bg-success/10' : 'opacity-40 cursor-not-allowed' }} 
                                {{ $class }}" 
                                wire:click="selectQuestion({{ $currentSectionIndex }}, {{ $qIndex }})"
                            >
                                {{ $qIndex + 1 }}
                                @if($isMarked)
                                    <div class="absolute -top-1.5 -right-1.5 text-warning filter drop-shadow-sm">
                                        <x-icon name="s-star" class="w-4 h-4" />
                                    </div>
                                @endif
                            </button>
                        @endforeach
                    </div>

                    <div class="mt-6 flex flex-wrap gap-x-4 gap-y-2 border-t border-gray-100 pt-4">
                        <button class="text-[11px] font-bold text-success hover:underline">Questions List</button>
                        <button class="text-[11px] font-bold text-success hover:underline">Instructions</button>
                    </div>
                </div>

                {{-- Legend & Submit --}}
                <div class="p-4 border-t-2 border-success/20 bg-gray-50/50">
                    <div class="grid grid-cols-2 gap-x-4 gap-y-2 text-[10px] font-bold uppercase mb-4 text-gray-600">
                        <div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-success"></span> Ans</div>
                        <div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-white border border-gray-300"></span> Not Ans</div>
                        <div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-success/20 border border-success/40"></span> Review</div>
                        <div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-gray-100 border border-gray-200"></span> Not Visited</div>
                    </div>
                    
                    <button 
                        wire:click="goToReview"
                        class="w-full bg-success text-white py-3 rounded-md font-extrabold text-xl shadow-lg hover:bg-success/90 transition-all uppercase tracking-tight"
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
